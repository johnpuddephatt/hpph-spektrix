<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SignupController extends Controller
{
    public function form()
    {
        $contact_preferences =
            Http::get('https://system.spektrix.com/' . nova_get_setting("spektrix_client_name") . '/api/v3/statements')->json();

        $tags =
            Http::get('https://system.spektrix.com/' . nova_get_setting("spektrix_client_name") . '/api/v3/tag-groups')->json();

        return view('signup', compact('contact_preferences', 'tags'));
    }

    public function submit(Request $request)
    {

        $request->validate([
            'email' => 'required|email',
            'firstName' => 'required',
            'lastName' => 'required',
        ]);

        $response = Http::post('https://system.spektrix.com/' . nova_get_setting("spektrix_client_name") . '/api/v3/customer', [
            'email' => $request->email,
            'firstName' => $request->firstName,
            'lastName' => $request->lastName,
            'AgreedStatements' => array_values($request->AgreedStatements ?? []),
            'Tags' => array_values($request->Tags ?? []),
            // 'attributes' => $request->attributes,
        ]);

        if ($response->badRequest()) {
            $this->updateExistingCustomer($request->all());
        }


        if ($response->created()) {
            return redirect()->route('signup.form')->with('success', 'You have successfully signed up!');
        }
    }

    protected function updateExistingCustomer($requestData)
    {

        $customerLookupUrl = 'https://system.spektrix.com/' . nova_get_setting("spektrix_client_name") . '/api/v3/customers?email=' . $requestData['email'];
        $response = Http::acceptJson()->withHeaders($this->generateHeaders($customerLookupUrl, 'GET'))->get($customerLookupUrl);

        if ($response->badRequest()) {
            return redirect()->route('signup.form')->with('error', 'Something went wrong');
        }
        if ($response->ok()) {

            $customerId = $response->json()['id'];

            foreach ($requestData['Tags'] as $tag) {

                $updateTagUrl = 'https://system.spektrix.com/' . nova_get_setting("spektrix_client_name") . '/api/v3/customers/' . $customerId . '/tags';
                $body = [
                    'id' => $tag
                ];

                $response = Http::withHeaders($this->generateHeaders($updateTagUrl, 'POST', json_encode($body)))->post($updateTagUrl, $body);
                if ($response->badRequest()) {
                    return redirect()->route('signup.form')->with('error', 'Something went wrong – tags could not be updated');
                }
            }

            $agreedStatementsBody = [];
            foreach ($requestData['AgreedStatements'] as $key => $value) {
                $agreedStatementsBody[] = [
                    'id' => $key,
                ];
            }
            $updateAgreedStatementsUrl = 'https://system.spektrix.com/' . nova_get_setting("spektrix_client_name") . '/api/v3/customers/' . $customerId . '/agreed-statements';

            // dd($updateAgreedStatementsUrl, json_encode($agreedStatementsBody), $this->generateHeaders($updateAgreedStatementsUrl, 'PUT', json_encode($agreedStatementsBody)));
            // 
            // Not sure what's happening here
            // the signature matches the one in the tool.
            // it's not an auth issue
            // remove the static date in the generateHeaders method to test for real

            // security issue here? someone could just send a post request to update someone else's agreed statements
            // possible issues with LHT too? not sure. people share accounts but don't know it!

            $response = Http::withHeaders($this->generateHeaders($updateAgreedStatementsUrl, 'PUT', json_encode($body)))->put($updateAgreedStatementsUrl, $body);

            dd($response);

            if ($response->badRequest()) {
                return redirect()->route('signup.form')->with('error', 'Something went wrong – agreed statements could not be updated');
            }
            return redirect()->route('signup.form')->with('success', 'Existing customer found and updated.');
        }
    }

    protected function generateHeaders($requestUrl, $httpMethod, $body = null)
    {
        $apiKey = env('SPEKTRIX_API_KEY');
        $apiUser = env('SPEKTRIX_API_USER');

        $dateTime = gmdate('D, d M Y H:i:s T');

        // if ($httpMethod !== 'GET') {
        //     $dateTime = 'Sat, 24 Aug 2023 23:48:35 GMT';
        // }
        $signatureString = $httpMethod . "\n" . $requestUrl . "\n" . $dateTime;

        if ($httpMethod !== 'GET') {

            $signatureString .= "\n";
            $body = md5($body, TRUE);
            $signatureString .= base64_encode($body);
        }
        $signedString = hash_hmac('sha1', $signatureString, base64_decode($apiKey), true);
        $signature = base64_encode($signedString);

        return [
            'Host' => 'system.spektrix.com',
            'Date' => $dateTime,
            'Authorization' => 'SpektrixAPI3 ' . $apiUser . ':' . $signature
        ];
    }
}
