<?php

// Affiche la page liste des marques
$router->map(
    'GET',
    '/brand/list',
    [
        'method' => 'list',
        'controller' => '\App\Controllers\BrandController'
    ],
    'brand-list'
);

// Affichage du formulaire ajouter une marque
$router->map(
    'GET',
    '/brand/add',
    [
        'method' => 'add',
        'controller' => '\App\Controllers\BrandController'
    ],
    'brand-add'
);

// Créer et modifier une marque dans la BDD
$router->map(
    'POST',
    '/brand/add',
    [
        'method' => 'createAndUpdate',
        'controller' => '\App\Controllers\BrandController'
    ],
    'brand-create-update'
);

// Page modifier une marque
$router->map(
    'GET',
    '/brand/[i:id]/edit',
    [
        'method' => 'edit',
        'controller' => '\App\Controllers\BrandController'
    ],
    'brand-edit'
);

// Route pour supprimer une marque
$router->map(
    'GET',
    '/brand/[i:id]/delete',
    [
        'method' => 'delete',
        'controller' => '\App\Controllers\BrandController'
    ],
    'brand-delete'
);