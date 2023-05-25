<?php

return [

    'merchant_login_id' => env('MERCHANT_LOGIN_ID'),
    'merchant_transaction_key' => env('MERCHANT_TRANSACTION_KEY'),

    'stripe_key' => env('STRIPE_KEY'),
    'stripe_secret' => env('STRIPE_SECRET'),
    'stripe_webhook_secret' => env('STRIPE_WEBHOOK_SECRET'),
    'stripe_standard_subscription' => env('STRIPE_STANDARD_SUBSCRIPTION'),
    'stripe_discount' => env('STRIPE_DISCOUNT'),

    'site_type' => env('APP_SITE', 'live'),

    'training_types' => [
        'Command & Leadership' => 'Command & Leadership',
        'Basic SWAT' => 'Basic SWAT',
        'Advanced SWAT' => 'Advanced SWAT',
        'Basic Precision Scoped Rifle' => 'Basic Precision Scoped Rifle',
    ],

    'shirt_size' => [
        'Men\'s Small' => 'Men\'s Small',
        'Men\'s Medium' => 'Men\'s Medium',
        'Men\'s Large' => 'Men\'s Large',
        'Men\'s XL' => 'Men\'s XL',
        'Men\'s 2XL' => 'Men\'s 2XL',
        'Men\'s 3XL' => 'Men\'s 3XL',
        'Women\'s Small' => 'Women\'s Small',
        'Women\'s Medium' => 'Women\'s Medium',
        'Women\'s Large' => 'Women\'s Large',
        'Women\'s XL' => 'Women\'s XL',
    ],

    'pants_waist' => [
        '28' => '28',
        '30' => '30',
        '32' => '32',
        '34' => '34',
        '36' => '36',
        '38' => '38',
        '40' => '40',
        '42' => '42',
        '44' => '44',
        '46' => '46',
        '2 - Ladies' => '2 - Ladies',
        '4 - Ladies' => '4 - Ladies',
        '6 - Ladies' => '6 - Ladies',
        '8 - Ladies' => '8 - Ladies',
        '10 - Ladies' => '10 - Ladies',
        '12 - Ladies' => '12 - Ladies',
        '14 - Ladies' => '14 - Ladies',
        '16 - Ladies' => '16 - Ladies',
        '18 - Ladies' => '18 - Ladies',

    ],

    'pants_inseam' => [
        '28' => '28',
        '30' => '30',
        '32' => '32',
        '34' => '34',
        '36' => '36',
        '38' => '38',
        '40' => '40',
        '42' => '42',
        '44' => '44',
        '46' => '46',
        'Short - Ladies' => 'Short - Ladies',
        'Regular - Ladies' => 'Regular - Ladies',
        'Long - Ladies' => 'Long - Ladies',
    ],

    'shoe_size' => [
        '7' => '7',
        '7.5' => '7.5',
        '8' => '8',
        '8.5' => '8.5',
        '9' => '9',
        '9.5' => '9.5',
        '10' => '10',
        '10.5' => '10.5',
        '11' => '11',
        '11.5' => '11.5',
        '12' => '12',
        '13' => '13',
        // '10' => '10',
        // '10 1/2' => '10 1/2',
        // '10 1/2 Wide' => '10 1/2 Wide',
        // '10.5' => '10.5',
        // '10.5 Wide' => '10.5 Wide',
        // '11' => '11',
        // '11 EE' => '11 EE',
        // '11.5' => '11.5',
        // '12' => '12',
        // '12.5' => '12.5',
        // '13' => '13',
        // '14' => '14',
        // '6.5' => '6.5',
        // '7' => '7',
        // '8' => '8',
        // '8.5' => '8.5',
        // '9' => '9',
        // '9 Women' => '9 Women',
        // '9.5' => '9.5',
        // 'W-8.5' => 'W-8.5',
    ],

    'conference_course_survey_questions' => [
        '1' => 'Overall course evaluation/rating',
        '2' => 'Rate the degree to which the course met your information and skill needs',
        '3' => 'Rate the degree to which the course improved your understanding and competence in this area',
    ],

    'expense_payer' => [
        'OTOA Paid' => 'OTOA Paid',
        'I paid, I need to be reimbursed' => 'I paid, I need to be reimbursed',
    ]
];