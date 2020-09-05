<?php

// Affiche la liste des types.
$router->map(
    'GET',
    '/type/list',
    [
        'method' => 'list',
        'controller' => '\App\Controllers\TypeController'
    ],
    'type-list'
);

?>