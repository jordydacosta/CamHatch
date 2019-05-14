<?php

return [


    'ch_price' => 9.99,
    'ch_bankaccount' => [
        'IBAN' => "BE80 7350 3769 3477",
        'bank' => "KBC, Belgium",
        'BIC' => "KREDBEBB"
    ],
    'ch_bankaccount_nl' => [
        'IBAN' => "NL19INGB0007817199",
        'bank' => "ING, Netherlands",
        'BIC' => "INGBNL2A"
    ],

    'ch_specs' => [
        'width' => [
            'mm' => 15,
            'inches' => 0.59
        ],
        'height' => [
            'mm' => 10,
            'inches' => 0.39
        ],
        'depth' => [
            'mm' => 0.7,
            'inches' => 0.02
        ]
    ],

    'order_status' => [
        'new' => 1,
        'pending_payment' => 2,
        'processing' => 3,
        'in_progress' => 4,
        'on_hold' => 5,
        'cancelled' => 6,
        'completed' => 7
    ],

    'payment_method' => [
        'mollie' => 1
    ],

    'shipping_plan' => [
        'bpost' => 1,
        'international' => 2,
        'free' => 3
    ],

    'delivery_cost' => [
        'bpost' => 2.50,
        'international' => 7.26
    ]
];