<<<<<<< HEAD


<?php
$db = [
    'driver'    => 'mysql',
    'host'      => getenv('DATABASE_HOST'),
    'db'  => getenv('DATABASE_NAME'),
    'username'  => getenv('DATABASE_USERNAME'),
    'password'  => getenv('DATABASE_PASSWORD'),
    'port'=> getenv('DATABASE_PORT'),
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix'    => '', //Cambiar al nombre de tu base de datos
];
?>
=======
<?php
    $db = [
        'driver'    => 'mysql',
        'host'      => getenv('DATABASE_HOST'),
        'db'  => getenv('DATABASE_NAME'),
        'username'  => getenv('DATABASE_USERNAME'),
        'password'  => getenv('DATABASE_PASSWORD'),
        'port'=> getenv('DATABASE_PORT'),
        'charset'   => 'utf8',
        'collation' => 'utf8_unicode_ci',
        'prefix'    => '', //Cambiar al nombre de tu base de datos
    ];
>>>>>>> 9eadbb6777b1cb1df795925ceeb259e9e1809fa2
?>