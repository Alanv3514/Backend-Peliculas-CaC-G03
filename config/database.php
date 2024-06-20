<?php

return [
    'database' => [
        'driver'    => 'mysql',
        'host'      => getenv('DATABASE_HOST'),
        'name'  => getenv('DATABASE_NAME'),
        'username'  => getenv('DATABASE_USERNAME'),
        'password'  => getenv('DATABASE_PASSWORD'),
        'port'=> getenv('DATABASE_PORT'),
        'charset'   => 'utf8',
        'collation' => 'utf8_unicode_ci',
        'prefix'    => '',
    ],
];


?>