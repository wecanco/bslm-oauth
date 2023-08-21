<?php

namespace BaSalam\Auth\Services;

use GuzzleHttp\Client;

class BaSalamAuth
{
    private string $redirect_uri;
    private string $state;
    private string $client_id;
    private string $client_secret;

    public function __construct()
    {
        $this->redirect_uri = config('ba_salam_auth.redirect_uri');
        $this->state = config('ba_salam_auth.state');
        $this->client_id = config('ba_salam_auth.client_id');
        $this->client_secret = config('ba_salam_auth.client_secret');
    }

    public function createAccessUrl(array $scopes): string
    {
        return config("ba_salam_auth.url.base_url") + config('ba_salam_auth.route.sso_url')."client_id=".config('ba_salam_auth.client_id').'&scopes='.implode(" ", $scopes)."&redirect_uri".$this->redirect_uri."&state=".$this->state;
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

        return $this->request(config("ba_salam_auth.url.auth_api"), config("ba_salam_auth.route.token_url"), $data);
    }

    private function request($baseUrl, $route, $data, $requestedHeaders = null)
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
