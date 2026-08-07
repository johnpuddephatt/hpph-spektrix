<?php

namespace Tests\Feature;

use App\Actions\SubscribeCustomer;
use App\Actions\SubscribeOutcome;
use App\Livewire\SignupForm as SignupFormComponent;
use App\Models\SignupForm;
use App\Models\SpektrixStatement;
use App\Models\SpektrixTag;
use Livewire\Livewire;
use Tests\TestCase;

/**
 * The signup form must only ever forward options it actually offered.
 *
 * Without this, anyone could craft a request assigning arbitrary Spektrix tags —
 * including internal segmentation tags — to a customer record.
 *
 * Runs against the development database rather than a transaction: the app cannot
 * boot against an empty schema (AppServiceProvider::boot queries AccessTag), so
 * RefreshDatabase is not usable here. Every row it creates is prefixed and removed
 * in tearDown.
 */
class SignupFormAllowlistTest extends TestCase
{
    private const PREFIX = 'TEST-ALLOWLIST-';

    protected function tearDown(): void
    {
        SpektrixTag::withoutGlobalScopes()
            ->where('id', 'like', self::PREFIX.'%')
            ->delete();
        SpektrixStatement::withoutGlobalScopes()
            ->where('id', 'like', self::PREFIX.'%')
            ->delete();
        SignupForm::where('name', 'like', self::PREFIX.'%')->delete();

        parent::tearDown();
    }

    public function test_it_drops_tags_and_statements_the_form_does_not_offer(): void
    {
        $offered = $this->tag('OFFERED');
        $otherForm = $this->tag('OTHER-FORM');
        $offeredStatement = $this->statement('OFFERED');
        $otherStatement = $this->statement('OTHER-FORM');

        $form = SignupForm::create([
            'name' => self::PREFIX.'form',
            'tags' => [$offered->id],
            'statements' => [$offeredStatement->id],
        ]);

        $captured = null;
        $this->spyOnSubscribe($captured);

        Livewire::test(SignupFormComponent::class, ['form' => $form])
            ->set('firstName', 'Test')
            ->set('lastName', 'Person')
            ->set('email', 'allowlist-test@example.com')
            ->set('selectedTags', [
                $offered->id,
                $otherForm->id,
                'TOTALLY-MADE-UP-TAG-ID',
            ])
            ->set('selectedStatements', [
                $offeredStatement->id,
                $otherStatement->id,
            ])
            ->call('submit')
            ->assertSet('submitted', true);

        $this->assertSame(
            [$offered->id],
            $captured['tags'],
            'Only the tag this form offers should reach Spektrix.'
        );
        $this->assertSame(
            [$offeredStatement->id],
            $captured['statements'],
            'Only the statement this form offers should reach Spektrix.'
        );
    }

    public function test_it_does_not_submit_when_validation_fails(): void
    {
        $form = SignupForm::create([
            'name' => self::PREFIX.'form',
            'tags' => [],
            'statements' => [],
        ]);

        $captured = null;
        $this->spyOnSubscribe($captured);

        Livewire::test(SignupFormComponent::class, ['form' => $form])
            ->set('firstName', 'Test')
            ->set('lastName', 'Person')
            ->set('email', 'not-an-email')
            ->call('submit')
            ->assertHasErrors(['email'])
            ->assertSet('submitted', false);

        $this->assertNull($captured, 'Spektrix must not be called on invalid input.');
    }

    private function spyOnSubscribe(&$captured): void
    {
        $spy = new class($captured) extends SubscribeCustomer
        {
            public function __construct(public &$captured)
            {
            }

            public function __invoke(
                string $email,
                string $firstName,
                string $lastName,
                array $tagIds = [],
                array $statementIds = []
            ): SubscribeOutcome {
                $this->captured = ['tags' => $tagIds, 'statements' => $statementIds];

                return SubscribeOutcome::Created;
            }
        };

        $this->app->instance(SubscribeCustomer::class, $spy);
    }

    private function tag(string $suffix): SpektrixTag
    {
        return SpektrixTag::create([
            'id' => self::PREFIX.$suffix,
            'enabled' => true,
            'name' => 'Test tag '.$suffix,
            'spektrix_tag_group_id' => null,
        ]);
    }

    private function statement(string $suffix): SpektrixStatement
    {
        return SpektrixStatement::create([
            'id' => self::PREFIX.'STMT-'.$suffix,
            'enabled' => true,
            'text' => 'Test statement '.$suffix,
        ]);
    }
}
