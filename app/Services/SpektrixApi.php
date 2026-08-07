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
    /**
     * Spektrix sits behind Cloudflare, which blocks POSTs carrying Guzzle's
     * default User-Agent with a 403 HTML error page. Any identifiable agent gets
     * through. Not part of the signature, so it can change freely.
     */
    protected const USER_AGENT = 'HPPH-Website/1.0 (+https://hydeparkpicturehouse.co.uk)';

    public function __construct(
        protected ?string $user,
        protected ?string $key,
    ) {
    }

    public function get(string $path, array $query = []): Response
    {
        return $this->send('GET', $path, null, $query);
    }

    /**
     * Unauthenticated "Web mode" read, for anything rendered on a public page.
     *
     * This is NOT just an unsigned get() — Spektrix returns different data
     * depending on whether the request is authenticated. Signing this promotes it
     * to "Owner mode", which returns every tag group including the ones flagged
     * web=false: internal segmentation like RFV, Dotdigital sync and staff tags.
     * Web mode returns only the web=true subset that is safe to show visitors.
     */
    public function webGet(string $path, array $query = []): Response
    {
        return Http::acceptJson()
            ->timeout(15)
            ->withHeaders(['User-Agent' => self::USER_AGENT])
            ->get($this->url($path, $query));
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
            'User-Agent' => self::USER_AGENT,
            'Authorization' => 'SpektrixAPI3 '.$this->user.':'.$signature,
        ];
    }
}
