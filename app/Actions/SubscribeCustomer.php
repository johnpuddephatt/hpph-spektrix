<?php

namespace App\Actions;

use App\Services\SpektrixApi;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Log;

/**
 * Signs a customer up to Spektrix, creating the record or updating an existing one.
 *
 * Returns an outcome rather than a redirect so the plain controller and the
 * Livewire component can present the result however each needs to.
 *
 * KNOWN RISK — accepted for now, to be closed by a confirmation flow.
 *
 * When the address already belongs to a customer, this updates that customer's
 * tags and agreed statements with no proof that the submitter owns the address.
 * Callers must rate limit, and must only pass ids the visitor was actually
 * offered — see App\Livewire\SignupForm, which intersects against the form's
 * configured allowlist.
 *
 * TODO: for an existing customer, write nothing on submit. Instead email a signed,
 * expiring URL (URL::temporarySignedRoute) and apply the changes only when that
 * link is followed.
 *
 * TODO: the agreed-statements endpoint only adds preferences, so a visitor cannot
 * withdraw consent here — unticking a box does nothing for an existing customer.
 * Needs PATCH /customers/{id}.
 */
class SubscribeCustomer
{
    public function __construct(protected SpektrixApi $spektrix)
    {
    }

    public function __invoke(
        string $email,
        string $firstName,
        string $lastName,
        array $tagIds = [],
        array $statementIds = []
    ): SubscribeOutcome {
        // Look the address up first rather than inferring "already exists" from a
        // failed create. Spektrix returns 400 for any validation problem, so a
        // bare 400 does not distinguish a duplicate from a malformed request.
        $lookup = $this->spektrix->get('customers', ['email' => $email]);

        if ($lookup->successful()) {
            $customerId = $this->customerId($lookup->json());

            if (! $customerId) {
                Log::error('Spektrix signup: no customer id in lookup response', [
                    'body' => $lookup->body(),
                ]);

                return SubscribeOutcome::Failed;
            }

            return $this->updateExisting($customerId, $tagIds, $statementIds);
        }

        // 404 is the documented "no such customer" answer, and the only status
        // that means we should go on to create one.
        if ($lookup->status() !== 404) {
            return $this->failed('look up customer by email', $lookup);
        }

        // Note the plural. /customer is the client-side "Web mode" endpoint; the
        // docs warn that server-side calls to it "are likely to be automatically
        // blocked", which is a Cloudflare 403. /customers is the "Owner mode"
        // endpoint intended for server-side use.
        $response = $this->spektrix->post('customers', [
            'email' => $email,
            'firstName' => $firstName,
            'lastName' => $lastName,
            'AgreedStatements' => array_values($statementIds),
            'Tags' => array_values($tagIds),
        ]);

        if ($response->successful()) {
            return SubscribeOutcome::Created;
        }

        // Covers the gap between the lookup and the create: Spektrix reports an
        // address that already exists as a 400 "Duplicate Entry".
        if (
            $response->status() === 400 &&
            str_contains($response->body(), 'Duplicate Entry')
        ) {
            $retry = $this->spektrix->get('customers', ['email' => $email]);

            if (
                $retry->successful() &&
                $customerId = $this->customerId($retry->json())
            ) {
                return $this->updateExisting($customerId, $tagIds, $statementIds);
            }
        }

        return $this->failed('create customer', $response);
    }

    protected function updateExisting(
        string $customerId,
        array $tagIds,
        array $statementIds
    ): SubscribeOutcome {
        $failed = false;

        // One call per tag. Collect failures rather than returning from inside the
        // loop, so a single bad tag doesn't silently skip the remaining ones.
        foreach ($tagIds as $tagId) {
            $response = $this->spektrix->post("customers/{$customerId}/tags", [
                'id' => $tagId,
            ]);

            if (! $response->successful()) {
                $failed = true;
                $this->log("add tag {$tagId}", $response);
            }
        }

        $statements = array_map(fn ($id) => ['id' => $id], array_values($statementIds));

        if ($statements !== []) {
            $response = $this->spektrix->post(
                "customers/{$customerId}/agreed-statements",
                $statements
            );

            if (! $response->successful()) {
                $failed = true;
                $this->log('update agreed statements', $response);
            }
        }

        return $failed ? SubscribeOutcome::Failed : SubscribeOutcome::Updated;
    }

    /**
     * GET /customers?email= returns a single customer object, or 404 if there is
     * no match — never an empty list.
     */
    protected function customerId(?array $body): ?string
    {
        return $body['id'] ?? null;
    }

    protected function failed(string $action, Response $response): SubscribeOutcome
    {
        $this->log($action, $response);

        return SubscribeOutcome::Failed;
    }

    protected function log(string $action, Response $response): void
    {
        Log::error("Spektrix signup: failed to {$action}", [
            'status' => $response->status(),
            'body' => $response->body(),
        ]);
    }
}
