<?php

// Affiche la liste des tags.
$router->map(
    'GET',
    '/tag/list',
    [
        'method' => 'list',
        'controller' => '\App\Controllers\TagController'
    ],
    'tag-list'
);

?>