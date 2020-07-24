<?php

// Affiche la page catégorie
$router->map(
    'GET',
    '/category/list',
    [
        'method' => 'list',
        'controller' => '\App\Controllers\CategoryController'
    ],
    'category-list'
);

// Affichage du formulaire ajouter une catégories
$router->map(
    'GET',
    '/category/add',
    [
        'method' => 'add',
        'controller' => '\App\Controllers\CategoryController'
    ],
    'category-add'
);

// Créer et modifier une catégorie dans la BDD
$router->map(
    'POST',
    '/category/add',
    [
        'method' => 'createAndUpdate',
        'controller' => '\App\Controllers\CategoryController'
    ],
    'category-create-update'
);

// Page modifier une catégorie
$router->map(
    'GET',
    '/category/[i:id]/edit',
    [
        'method' => 'edit',
        'controller' => '\App\Controllers\CategoryController'
    ],
    'category-edit'
);

// Route pour supprimer une catégorie
$router->map(
    'GET',
    '/category/[i:id]/delete',
    [
        'method' => 'delete',
        'controller' => '\App\Controllers\CategoryController'
    ],
    'category-delete'
);

// .............
$router->map(
    'GET|POST',
    '/category/homepage-selection',
    [
        'method' => 'homepageSelection',
        'controller' => '\App\Controllers\CategoryController'
    ],
    'category-homepage_selection'
);