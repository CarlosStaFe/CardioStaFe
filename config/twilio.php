<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Twilio Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for Twilio SMS and WhatsApp services
    |
    */
    
    'sid' => env('TWILIO_SID'),
    'auth_token' => env('TWILIO_AUTH_TOKEN'),
    'phone_number' => env('TWILIO_PHONE_NUMBER'),
    'whatsapp_number' => env('TWILIO_WHATSAPP_NUMBER'),
    
    /*
    |--------------------------------------------------------------------------
    | Default Country Code
    |--------------------------------------------------------------------------
    |
    | Default country code for phone number formatting
    | Argentina: +54
    |
    */
    'default_country_code' => '+54',
    'default_mobile_code' => '9', // Código para móviles en Argentina
];