<?php

return [
    /*
    |--------------------------------------------------------------------------
    | WhatsApp API Configuration
    |--------------------------------------------------------------------------
    |
    | Configure your WhatsApp API provider here. You can use services like:
    | - WhatsApp Business API
    | - Twilio
    | - ChatAPI
    | - Or any other WhatsApp gateway
    |
    */

    'api_url' => env('WHATSAPP_API_URL', null),
    'api_token' => env('WHATSAPP_API_TOKEN', null),
    
    /*
    |--------------------------------------------------------------------------
    | Default Settings
    |--------------------------------------------------------------------------
    */
    'default_country_code' => env('WHATSAPP_DEFAULT_COUNTRY_CODE', '62'), // Indonesia
];
