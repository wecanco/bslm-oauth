<?php

namespace BaSalam\Auth\Services\ExternalServices;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Illuminate\Http\RedirectResponse;

class Auth
{

    private string $scopes;
    private string $redirect_uri;
    private string $state;
    private string $client_id;
    private string $client_secret;

    public function __construct()
    {
        $this->scopes = implode(" ", config('ba_salam_auth.scopes'));
        $this->redirect_uri = implode(" ", config('ba_salam_auth.redirect_uri'));
        $this->state = implode(" ", config('ba_salam_auth.state'));
        $this->client_id = implode(" ", config('ba_salam_auth.client_id'));
        $this->client_secret = implode(" ", config('ba_salam_auth.client_secret'));
    }

    public function createAccessUrl(): string
    {
        return config("ba_salam_auth.url.base_url") + config('ba_salam_auth.route.sso_url')."client_id=".config('ba_salam_auth.client_id').'&scopes='.$this->scopes."&redirect_uri".$this->redirect_uri."&state=".$this->state;
    }

    public function getToken()
    {
        $data = [
            "grant_type" => "client_credentials",
            "client_secret" => $this->client_secret,
            "client_id" => $this->client_id,
            "scope" => $this->scopes
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

    public function verifyToken(mixed $token)
    {
        $header = [
            'Authorization' => 'Bearer'.$token
        ];

        return $this->request(config("ba_salam_auth.url.auth_api"), config("ba_salam_auth.route.who_ami_url"), [], $header);
    }

}
