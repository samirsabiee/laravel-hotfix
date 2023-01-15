<?php

return [

    'path' => '*.php',

    'database' => [

        'transaction' => false,

        'connection' => config('database.default'),

        'table' => 'hotfixes'

    ],

];
