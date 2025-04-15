<?php

return [
    'entitlements' => [
        'feature1' => 'Feature 1',
        'feature2' => 'Feature 2',
        'feature3' => 'Feature 3',
    ],
    'licensing' => [
        'length' => env('CODE_LENGTH', 15),
        'segment_length' => env('CODE_SEGMENT_LENGTH', 6),
        'uppercase' => (bool) env('CODE_UPPERCASE', false),
    ],
    'license_statuses' => [
        'fresh' => 'Fresh',
        'active' => 'Active',
        'revoked' => 'Revoked',
    ],
    'platforms' => [
        'windows' => 'Windows',
        'linux' => 'Linux',
        'osx' => 'Mac OS X',
        'osx-m1' => 'Mac OS X (M1)',
    ],
];
