<?php

namespace App\Services;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

/**
 * Signed client for the Spektrix v3 API.
 *
 * Read endpoints (events, statements, tag groups) are public and can be hit with
 * a plain Http::get(). Anything that writes must be signed per
 * https://integrate.spektrix.com/docs/authentication.
 *
 * The signature covers a hash of the request body, so the bytes that are hashed
 * and the bytes that go on the wire have to be identical. That is why send()
 * encodes the payload once and hands the same string to both headers() and
 * withBody() — passing an array to Http::post() would let Guzzle re-encode it
 * independently and silently invalidate the signature.
 */
class SpektrixApi
{
    public function __construct(
        protected ?string $user,
        protected ?string $key,
    ) {
    }

    public function get(string $path, array $query = []): Response
    {
        return $this->send('GET', $path, null, $query);
    }

    public function post(string $path, array $body): Response
    {
        return $this->send('POST', $path, $body);
    }

    public function put(string $path, array $body): Response
    {
        return $this->send('PUT', $path, $body);
    }

    protected function send(string $method, string $path, ?array $body, array $query = []): Response
    {
        $url = $this->url($path, $query);

        // Encode once: sign this exact string, send this exact string.
        $payload = $body === null ? null : json_encode($body);

        $request = Http::acceptJson()
            ->timeout(15)
            ->withHeaders($this->headers($url, $method, $payload));

        if ($payload !== null) {
            $request = $request->withBody($payload, 'application/json');
        }

        return $request->send($method, $url);
    }

    /**
     * Build the absolute URL. The signature covers the URI, so this must produce
     * exactly what Guzzle ends up requesting — query string included.
     */
    public function url(string $path, array $query = []): string
    {
        $url = 'https://system.spektrix.com/'
            .nova_get_setting('spektrix_client_name')
            .'/api/v3/'
            .ltrim($path, '/');

        return $query === [] ? $url : $url.'?'.http_build_query($query);
    }

    /**
     * StringToSign = METHOD "\n" URI "\n" Date [ "\n" BASE-64(MD5(body)) ]
     * Signature    = BASE-64(HMAC-SHA1(BASE-64-DECODE(SecretKey), StringToSign))
     */
    protected function headers(string $url, string $method, ?string $body): array
    {
        // RFC 7231 date, always UTC.
        $date = gmdate('D, d M Y H:i:s \G\M\T');

        $stringToSign = $method."\n".$url."\n".$date;

        if ($body !== null) {
            // Raw 16-byte MD5, then base 64 — not the hex digest.
            $stringToSign .= "\n".base64_encode(md5($body, true));
        }

        // The secret key is issued base-64 encoded and must be decoded first.
        $signature = base64_encode(
            hash_hmac('sha1', $stringToSign, base64_decode($this->key), true)
        );

        return [
            'Date' => $date,
            'Authorization' => 'SpektrixAPI3 '.$this->user.':'.$signature,
        ];
    }
}
