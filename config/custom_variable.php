<?php


use Illuminate\Support\Facades\Cache;

return [
    'sms_configuration' => [
        'sms_api_url' => env('SMS_API_URL',''),
        'sms_api_username' => env('SMS_API_USERNAME',''),
        'sms_api_secret' => env('SMS_API_SECRET',''),
    ],
    'app_name' => env('APP_NAME'),
    'logo_path' => 'public/static/logo.png',
    'backup_day' => env('BACKUP_DAY','sunday'),
    'site_url' => env('APP_URL','crescentpharmaltd.com'),
    'asset_version' => env('ASSET_VERSION') ?? '1.2.1',
];
