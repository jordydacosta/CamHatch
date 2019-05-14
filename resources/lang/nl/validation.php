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
    "between.numeric" => "De ':attribute' moet minimaal :min zijn en maximaal :max",
    "required" => "Gelieve ':attribute' in te vullen.",
    "email" => "Gelieve een geldig e-mailadres in te voegen.",

    'min' => [
        'numeric' => "De ':attribute' moet minimum :min zijn.",
    ],

    "numeric" => "De ':attribute' moet een nummer zijn.",
    "required_without" => "Het :attribute veld is vereist wanneer :values niet aanwezig zijn.",

    'captcha' => 'Gelieve te bevestigen dat u geen robot bent.',

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
        'firstname' => "Gelieve 'Voornaam' in te vullen.",
        'lastname' => "Gelieve 'Achternaam' in te vullen.",
        'phone' => "Gelieve 'Telefoon' in te vullen.",
        'company' => "Gelieve 'Bedrijf' in te vullen.",
        'address' => "Gelieve 'Adres' in te vullen.",
        'zipcode' => "Gelieve 'Postcode' in te vullen.",
        'city' => "Gelieve 'Stad' in te vullen.",
        'email' => "Gelieve 'E-mailadres' in te vullen.",

        'name' => "Gelieve 'Naam' in te vullen.",
        'review' => "Gelieve 'Review' in te vullen.",
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

        'name' => 'Naam',
        'email' => 'E-mailadres',
        'contact-message' => 'Bericht',
        'quantity' => 'Hoeveelheid'
    ],

];
