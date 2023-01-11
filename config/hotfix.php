<?php
use Illuminate\Support\Facades\Facade;

return [

    'path' => 'app/Hotfixes/*.php',

    'database' => [

        'transaction' => false,

        'connection' => 'pgsql',

        'table' => 'hotfixes'

    ],

];
