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

// Affiche le formulaire d'ajout d'un type
$router->map(
    'GET',
    '/type/add',
    [
        'method' => 'add',
        'controller' => '\App\Controllers\TypeController'
    ],
    'type-add'
);

// Créer et modifier un type dans la BDD
$router->map(
    'POST',
    '/type/add',
    [
        'method' => 'createAndUpdate',
        'controller' => '\App\Controllers\TypeController'
    ],
    'type-create-update'
);

// Page pour modifier un type
$router->map(
    'GET',
    '/type/[i:id]/edit',
    [
        'method' => 'edit',
        'controller' => '\App\Controllers\TypeController'
    ],
    'type-edit'
);

// Route pour supprimer un type
$router->map(
    'GET',
    '/type/[i:id]/delete',
    [
        'method' => 'delete',
        'controller' => '\App\Controllers\TypeController'
    ],
    'type-delete'
);

?>