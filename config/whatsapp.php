<?php

$raw = (string) env('WHATSAPP_PHONE', '96170604010');
$phone = preg_replace('/\D+/', '', $raw);
$phone = $phone !== '' ? $phone : '96170604010';

return [
    /*
    | Digits only (country code + number, no +). Used for https://wa.me/...
    */
    'phone' => $phone,

    /*
    | Optional human-readable label (e.g. +961 70 604 010). Shown in the footer when set.
    */
    'label' => env('WHATSAPP_PHONE_LABEL'),

    'url' => 'https://wa.me/'.$phone,
];
