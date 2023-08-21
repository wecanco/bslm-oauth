<?php

namespace BaSalam\Auth\Services\ExternalServices;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

class PlatformCore
{
    public static function getCurrentUser($token)
    {
        $query = [];
        $handler = config('ba_salam_auth.route.platform_core_V1_user');
        $header = ['Authorization' => $token];

        return self::request($query, $handler, 'GET', $header);
    }

    public static function getCurrentUserVendor($token)
    {
        $query = [];
        $handler = config('ba_salam_auth.route.platform_core_V1_vendor');
        $header = ['Authorization' => $token];

        return self::request($query, $handler, 'GET', $header);
    }

    public static function getUserByHashId(string  $hashId)
    {
        $query = [];
        $handler = config('ba_salam_auth.route.platform_core_V1_user') . '/' . $hashId;

        return self::request($query, $handler, 'GET');
    }

    public static function getUserById($userId)
    {
        $query = ['user_ids' => $userId];
        $handler = config('ba_salam_auth.route.platform_core_V1_get_user_by_ids');

        return self::request($query, $handler, 'GET');
    }

    public static function getVendorById($vendorId)
    {
        $query = [];
        $handler = config('ba_salam_auth.route.platform_core_V1_vendor') . '/' . $vendorId . '/';

        return self::request($query, $handler, 'GET');
    }

    private static function request($query, $handler, $method, $requestedHeaders = null)
    {
        $client = new Client([
            'timeout' => 30,
            'http_errors' => false,
            'base_uri' => config('ba_salam_auth.url.platform_core'),
            'verify' => false
        ]);

        $headers = ['User-Agent' => 'basalam-ads-system'];
        if (!is_null($requestedHeaders)) {
            $headers = array_merge($headers, $requestedHeaders);
        }

        return $client->request($method, $handler, [
            RequestOptions::HEADERS => $headers,
            RequestOptions::QUERY => $query
        ]);
    }
}

