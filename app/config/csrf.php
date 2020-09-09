<?php

// Liste des routes pour lesquelles activer la sécurisation contre les attaques CSRF.

// Pour toutes ces actions, on va vérifier la présence et la validité d'un tokenCSRF.

$csrf = [
    'authenticate',

    'user-create',
    'user-update',
    'user-delete',

    'category-create-update',
    'category-delete',
    'category-homepage_selection',

    'product-create-update',
    'product-delete',

    'type-create-update',
    'type-delete',

    'brand-create-update',
    'brand-delete',

    'tag-create-update',
    'tag-delete',
];