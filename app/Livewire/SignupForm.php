<?php

namespace App\Livewire;

use App\Actions\SubscribeCustomer;
use App\Actions\SubscribeOutcome;
use App\Models\SignupForm as SignupFormModel;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Component;

/**
 * Renders one configured signup form.
 *
 * Livewire rather than a plain POST because this block can land on any page, and
 * pages are full-page cached by Spatie ResponseCache. A redirect-and-flash success
 * message cannot render from a cached page; component state can.
 */
class SignupForm extends Component
{
    public int $formId;

    public string $firstName = '';

    public string $lastName = '';

    public string $email = '';

    /** @var array<int, string> */
    public array $selectedTags = [];

    /** @var array<int, string> */
    public array $selectedStatements = [];

    public bool $submitted = false;

    public ?string $formError = null;

    public function mount(SignupFormModel $form): void
    {
        $this->formId = $form->id;
    }

    protected function rules(): array
    {
        return [
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'selectedTags' => 'array',
            'selectedTags.*' => 'string',
            'selectedStatements' => 'array',
            'selectedStatements.*' => 'string',
        ];
    }

    protected function validationAttributes(): array
    {
        return [
            'firstName' => 'first name',
            'lastName' => 'last name',
            'email' => 'email address',
        ];
    }

    public function submit(SubscribeCustomer $subscribe): void
    {
        $this->formError = null;
        $this->validate();

        // Livewire submissions all go through /livewire/update, so a per-route
        // throttle would never see them.
        $key = 'signup-form:'.request()->ip();

        if (RateLimiter::tooManyAttempts($key, 5)) {
            $this->formError = 'Too many attempts. Please try again in a minute.';

            return;
        }

        RateLimiter::hit($key, 60);

        $form = $this->form();

        // Never trust the ids in the payload: only send options this form actually
        // offers. Without this, a crafted request could assign any Spektrix tag —
        // including internal segmentation tags — to a customer.
        $tags = array_values(array_intersect($this->selectedTags, $form->tags ?? []));
        $statements = array_values(
            array_intersect($this->selectedStatements, $form->statements ?? [])
        );

        $outcome = $subscribe(
            $this->email,
            $this->firstName,
            $this->lastName,
            $tags,
            $statements
        );

        if ($outcome === SubscribeOutcome::Failed) {
            $this->formError = 'Sorry, something went wrong. Please try again.';

            return;
        }

        $this->submitted = true;
    }

    protected function form(): SignupFormModel
    {
        return SignupFormModel::findOrFail($this->formId);
    }

    public function render()
    {
        $form = $this->form();

        return view('livewire.signup-form', [
            'form' => $form,
            'tagsByGroup' => $form->tagsByGroup(),
            'statements' => $form->selectedStatements(),
        ]);
    }
}
