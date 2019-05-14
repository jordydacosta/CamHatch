<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */
    "between.numeric" => "The ':attribute' must be between one and one hundred",
    "required" => "Please fill in ':attribute'.",
    "email" => "Please enter a valid email address",
    'taxes'=> "Please enter a valid number",

    'min' => [
        'numeric' => 'The :attribute must be at least :min.',
    ],
    'numeric' => 'The :attribute must be a number.',
    "required_without" => "The :attribute field is required when :values is not present.",
    'captcha' => 'Please confirm that you are not a robot.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'firstname' => "Please fill in 'First name'",
        'lastname' => "Please fill in 'Last name'",
        'phone' => "Please fill in 'Phone'",
        'company' => "Please fill in 'Company'",
        'address' => "Please fill in 'Address'",
        'zipcode' => "Please fill in 'Zipcode'",
        'city' => "Please fill in 'City'",
        'email' => "Please fill in 'Email address'",
        'taxes' => "Please fill in 'Taxes'",
        'name' => "Please fill in 'Name'",
        'review' => "Please fill in 'Review'",
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [
        'name' => 'Name',
        'email' => 'Email address',
        'Taxes' => 'Taxes',
        'contact-message' => 'Message',
        'quantity' => 'Quantity',
        'g-recaptcha-response' => 'Captcha'
    ],

];
