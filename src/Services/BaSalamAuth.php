<?php

namespace BaSalam\Auth\Services;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

class BaSalamAuth
{
    private string $redirect_uri;
    private string $client_id;
    private string $client_secret;

    public function __construct()
    {
        $this->redirect_uri = config('basalam_auth.redirect_uri');
        $this->client_id = config('basalam_auth.client_id');
        $this->client_secret = config('basalam_auth.client_secret');
    }

    public function createAccessUrl(array $scopes, $state): string
    {
        return config("basalam_auth.url.base_url") + config('basalam_auth.route.sso_url')."client_id=".config('basalam_auth.client_id').'&scopes='.implode(" ", $scopes)."&redirect_uri".$this->redirect_uri."&state=".$state;
    }

    public function getToken($code)
    {
        $data = [
            "grant_type" => "authorization_code",
            "client_secret" => $this->client_secret,
            "client_id" => $this->client_id,
            "redirect_uri" => $this->redirect_uri,
            "code" => $code
        ];

        return $this->request(config("basalam_auth.url.auth_api"), config("basalam_auth.route.token_url"), $data);
    }

    private function request($baseUrl, $route, $data, $requestedHeaders = null): ResponseInterface
    {
        $client = new Client([
            'timeout' => 15,
            'http_errors' => false,
            'base_uri' => $baseUrl,
            'verify' => false
        ]);

        $headers = ['User-Agent' => 'basalam-ads-system', 'Content-Type' => 'application/json', 'Accept' => 'application/json'];
        if (!is_null($requestedHeaders)) {
            $headers = array_merge($headers, $requestedHeaders);
        }

        return $client->post($route, [
            'headers' => $headers,
            'body'    => json_encode($data)
        ]);
    }

}
