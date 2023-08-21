<?php

return [
    'scopes'        =>  [
        "user.read",
        "user.write",
        "vendor.read",
        "vendor.write",
    ],

    'redirect_uri'  =>  'https://domain.com/token',
    'client_id'     =>  '54623',
    'client_secret' =>  '54623',
    'state'         =>  '2135',

    'url' => [
        'platform_core' => 'https://core.basalam.com',
        'auth_api'      => 'https://auth.basalam.com',
        'base_url'      => 'https://basalam.com',
        'core_api'      => 'https://api.basalam.com/api',
    ],

    'route' => [
        'platform_core_V1_user'            => '/api_v1.0/user',
        'platform_core_V1_vendor'          => '/api_v1.0/vendor',
        'platform_core_V1_get_user_by_ids' => '/api_v1.0/user/get-by-ids/',

        'sso_url'       =>  '/accounts/sso',
        'token_url'     =>  '/oauth/token',
        'who_ami_url'   =>  '/whoami',
    ],
];
