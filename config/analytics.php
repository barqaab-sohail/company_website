<?php

return [
    'enabled' => (bool) env('ANALYTICS_ENABLED', false),
    'provider' => env('ANALYTICS_PROVIDER', 'plausible'),
    'plausible_domain' => env('PLAUSIBLE_DOMAIN'),
    'plausible_script' => env('PLAUSIBLE_SCRIPT', 'https://plausible.io/js/script.js'),
    'google_measurement_id' => env('GOOGLE_ANALYTICS_ID'),
];
