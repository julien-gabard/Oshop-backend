<?php

// Affiche la page connexion
$router->map(
    'GET',
    '/login',
    [
        'method' => 'login',
        'controller' => '\App\Controllers\SessionController'
    ],
    'login'
);

// Récupère les champs du formulaire de la page connexion
$router->map(
    'POST',
    '/login',
    [
        'method' => 'authenticate',
        'controller' => '\App\Controllers\SessionController'
    ],
    'authenticate'
);

// Permet de se deconnecter de la session
$router->map(
    'GET',
    '/logout',
    [
        'method' => 'logout',
        'controller' => '\App\Controllers\SessionController'
    ],
    'logout'
);