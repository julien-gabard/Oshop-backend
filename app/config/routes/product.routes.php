<?php

// Affiche la page produit
$router->map(
    'GET',
    '/product/list',
    [
        'method' => 'list',
        'controller' => '\App\Controllers\ProductController'
    ],
    'product-list'
);

// Affichage du formulaire ajouter un produit
$router->map(
    'GET',
    '/product/add',
    [
        'method' => 'add',
        'controller' => '\App\Controllers\ProductController'
    ],
    'product-add'
);

// Créer et modifier un produit dans la BDD
$router->map(
    'POST',
    '/product/add',
    [
        'method' => 'createAndUpdate',
        'controller' => '\App\Controllers\ProductController'
    ],
    'product-create-update'
);

// Page modifier un produit
$router->map(
    'GET',
    '/product/[i:id]/edit',
    [
        'method' => 'edit',
        'controller' => '\App\Controllers\ProductController'
    ],
    'product-edit'
);

// Route pour supprimer un produit
$router->map(
    'GET',
    '/product/[i:id]/delete',
    [
        'method' => 'delete',
        'controller' => '\App\Controllers\ProductController'
    ],
    'product-delete'
);

// Route pour gerer le home order des produits
$router->map(
    'GET|POST',
    '/product/homepage-selection',
    [
        'method' => 'homepageSelection',
        'controller' => '\App\Controllers\ProductController'
    ],
    'product-homepage_selection'
);