<?php

return [
    'minimum_users' => env('MIN_USERS', 100),
    'nationality'   => env('NATIONALITY', 'AU'),
    'base_uri'      => env('API_BASE_URI', 'https://randomuser.me/api'),
    'fields'        => env('API_FIELDS', 'name,email,login,gender,location,phone')
];