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

// Affiche le formulaire d'ajout d'un tag
$router->map(
    'GET',
    '/tag/add',
    [
        'method' => 'add',
        'controller' => '\App\Controllers\TagController'
    ],
    'tag-add'
);

// Créer et modifier un tag dans la BDD
$router->map(
    'POST',
    '/tag/add',
    [
        'method' => 'createAndUpdate',
        'controller' => '\App\Controllers\TagController'
    ],
    'tag-create-update'
);

// Page pour modifier un tag
$router->map(
    'GET',
    '/tag/[i:id]/edit',
    [
        'method' => 'edit',
        'controller' => '\App\Controllers\TagController'
    ],
    'tag-edit'
);

// Route pour supprimer un tag
$router->map(
    'GET',
    '/tag/[i:id]/delete',
    [
        'method' => 'delete',
        'controller' => '\App\Controllers\TagController'
    ],
    'tag-delete'
);

?>