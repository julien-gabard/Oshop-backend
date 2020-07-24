<?php

// Affiche le formulaire de création d'un utilisateur
$router->map(
    'GET',
    '/user/add',
    [
        'method' => 'add',
        'controller' => '\App\Controllers\AppUserController'
    ],
    'user-add'
);

// Donnée du formulaire de création d'un utilisateur
$router->map(
    'POST',
    '/user/add',
    [
        'method' => 'create',
        'controller' => '\App\Controllers\AppUserController'
    ],
    'user-create'
);

// Page modifier un utilisateur
$router->map(
    'GET',
    '/user/[i:id]/edit',
    [
        'method' => 'edit',
        'controller' => '\App\Controllers\AppUserController'
    ],
    'user-edit'
);

// Donnée du formulaire de modification d'un utilisateur
$router->map(
    'POST',
    '/user/[i:id]/edit',
    [
        'method' => 'update',
        'controller' => '\App\Controllers\AppUserController'
    ],
    'user-update'
);

// Permet d'afficher la liste des utilisateur
$router->map(
    'GET',
    '/user/list',
    [
        'method' => 'list',
        'controller' => '\App\Controllers\AppUserController'
    ],
    'user-list'
);

// Permet de supprimer un utilisateur
$router->map(
    'GET',
    '/user/[i:id]/delete',
    [
        'method' => 'delete',
        'controller' => '\App\Controllers\AppUserController'
    ],
    'user-delete'
);