<?php

return [
    // set your paypal credential
    'client_id' => env('PAYPAL_CLIENT_ID'),
    'secret' => env('PAYPAL_SECRET'),

    // Set the paypal credentials from multiple countries
    'client_id_nl' => env('PAYPAL_CLIENT_ID_NL'),
    'secret_nl' => env('PAYPAL_SECRET_NL'),

    /**
     * SDK configuration
     */
    'settings' => [
        /**
         * Available option 'sandbox' or 'live'
         */
        'mode' => env('PAYPAL_MODE'),

        /**
         * Specify the max request time in seconds
         */
        'http.ConnectionTimeOut' => 30,

        /**
         * Whether want to log to a file
         */
        'log.LogEnabled' => true,

        /**
         * Specify the file that want to write on
         */
        'log.FileName' => storage_path() . '/logs/paypal.log',

        /**
         * Available option 'FINE', 'INFO', 'WARN' or 'ERROR'
         *
         * Logging is most verbose in the 'FINE' level and decreases as you
         * proceed towards ERROR
         */
        'log.LogLevel' => 'ERROR'
    ]
];