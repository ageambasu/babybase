<?php

return [
    'allow_password_login' =>      env('ALLOW_PASSWORD_LOGIN'),
    'client_id' =>                 env('OAUTH_CLIENT_ID'),
    'client_secret' =>             env('OAUTH_CLIENT_SECRET'),
    'auth_url' =>                  env('OAUTH_AUTH_URL'),
    'access_token_url' =>          env('OAUTH_ACCESS_TOKEN_URL'),
    'user_info_url' =>             env('OAUTH_USER_INFO_URL'),
    'scope' =>                     env('OAUTH_SCOPE'),
    'callback_url' =>              env('OAUTH_CALLBACK_URL'),
];

?>
