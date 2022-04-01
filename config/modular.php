<?php
return [
    'path' => base_path() . '/app/Modules',
    'base_namespace' => 'App\Modules',

    'groupMidleware' => [
        'web' => ['auth'],
    ],

    'modules' => [
        'Users',
        'Main',
        'Company',
        'Products',
        'Dashboard',
        'Parameters',
        'Customers',
    ]
];