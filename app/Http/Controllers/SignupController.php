<?php

namespace App\Http\Controllers;

use App\Services\SpektrixApi;
use Illuminate\Http\Client\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Mailing-list signup, writing straight through to Spektrix.
 *
 * KNOWN RISK — accepted for now, to be closed by a confirmation flow.
 *
 * Submitting an address that already belongs to a Spektrix customer updates that
 * customer's tags and agreed statements with no proof that the submitter owns the
 * address. The differing responses for known and unknown addresses also let a
 * caller enumerate which emails are registered customers. The POST route is rate
 * limited, which raises the cost of abuse but does not remove either problem.
 *
 * TODO: for an existing customer, write nothing on submit. Instead email a signed,
 * expiring URL (Illuminate\Support\Facades\URL::temporarySignedRoute) and apply the
 * changes only when that link is followed.
 */
class SignupController extends Controller
{
    /**
     * Shown to the visitor whenever a Spektrix call fails. Spektrix's own error
     * messages go to the log, never to the page.
     */
    protected const GENERIC_ERROR = 'Sorry, something went wrong. Please try again.';

    public function __construct(protected SpektrixApi $spektrix)
    {
    }

    public function form()
    {
        // Statements and tag groups are public reads, so they go unsigned.
        $contact_preferences = Http::get($this->spektrix->url('statements'))->json();
        $tags = Http::get($this->spektrix->url('tag-groups'))->json();

        return view('signup', compact('contact_preferences', 'tags'));
    }

    public function submit(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'firstName' => 'required',
            'lastName' => 'required',
            'AgreedStatements' => 'array',
            'Tags' => 'array',
        ]);

        $response = $this->spektrix->post('customer', [
            'email' => $request->email,
            'firstName' => $request->firstName,
            'lastName' => $request->lastName,
            'AgreedStatements' => $this->ids($request, 'AgreedStatements'),
            'Tags' => $this->ids($request, 'Tags'),
        ]);

        if ($response->successful()) {
            return redirect()
                ->route('signup.form')
                ->with('success', 'You have successfully signed up!');
        }

        // Spektrix answers 400 when the address already belongs to a customer.
        if ($response->status() === 400) {
            return $this->updateExistingCustomer($request);
        }

        // Anything else — 401/403 signature rejection, 5xx, a timeout — is ours
        // to fix, not the visitor's.
        return $this->failed('create customer', $response);
    }

    protected function updateExistingCustomer(Request $request)
    {
        $response = $this->spektrix->get('customers', ['email' => $request->email]);

        if (! $response->successful()) {
            return $this->failed('look up customer by email', $response);
        }

        $customerId = $this->customerId($response->json());

        if (! $customerId) {
            Log::error('Spektrix signup: no customer id in lookup response', [
                'body' => $response->body(),
            ]);

            return redirect()->route('signup.form')->with('error', self::GENERIC_ERROR);
        }

        $failures = [];

        // One call per tag. Collect failures rather than returning from inside the
        // loop, so a single bad tag doesn't silently skip the remaining ones.
        foreach ($this->ids($request, 'Tags') as $tagId) {
            $tagResponse = $this->spektrix->post("customers/{$customerId}/tags", [
                'id' => $tagId,
            ]);

            if (! $tagResponse->successful()) {
                $failures[] = 'tags';
                $this->log("add tag {$tagId}", $tagResponse);
            }
        }

        $statements = array_map(
            fn ($id) => ['id' => $id],
            $this->ids($request, 'AgreedStatements')
        );

        if ($statements !== []) {
            // TODO: confirm verb and semantics against the Spektrix docs. If this
            // endpoint appends rather than replaces, an unticked box can never
            // withdraw consent — the form only submits ticked boxes.
            $statementsResponse = $this->spektrix->post(
                "customers/{$customerId}/agreed-statements",
                $statements
            );

            if (! $statementsResponse->successful()) {
                $failures[] = 'statements';
                $this->log('update agreed statements', $statementsResponse);
            }
        }

        if ($failures !== []) {
            return redirect()->route('signup.form')->with('error', self::GENERIC_ERROR);
        }

        return redirect()
            ->route('signup.form')
            ->with('success', 'Your preferences have been updated.');
    }

    /**
     * Ids of the ticked checkboxes. The form sets both the array key and the value
     * to the Spektrix id, so read the values.
     */
    protected function ids(Request $request, string $field): array
    {
        return array_values($request->input($field, []));
    }

    /**
     * Pull the customer id out of a lookup response, tolerating either a single
     * customer object or a list of them.
     *
     * TODO: pin this to whichever shape the docs specify and drop the other branch.
     */
    protected function customerId(?array $body): ?string
    {
        if (empty($body)) {
            return null;
        }

        return $body['id'] ?? $body[0]['id'] ?? null;
    }

    protected function failed(string $action, Response $response)
    {
        $this->log($action, $response);

        return redirect()->route('signup.form')->with('error', self::GENERIC_ERROR);
    }

    protected function log(string $action, Response $response): void
    {
        Log::error("Spektrix signup: failed to {$action}", [
            'status' => $response->status(),
            'body' => $response->body(),
        ]);
    }
}
