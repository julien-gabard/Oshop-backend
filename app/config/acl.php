<?php

// ACL : Access Control List

$acl = [
    'main-home' => ['admin', 'catalog-manager', 'super-admin'],

    // 'login' => [], => pas besoin, la route est libre d'accès

    'user-list'   => ['admin', 'super-admin'],
    'user-add'    => ['admin', 'super-admin'],
    'user-create' => ['admin', 'super-admin'],
    'user-edit'   => ['admin', 'super-admin'],
    'user-update' => ['admin', 'super-admin'],
    'user-delete' => ['admin', 'super-admin'],
    // whoa, ce serait pratique de pouvoir définir l'ACL directement pour un contrôleur...

    // Méga-Bonus (code-review) : gestion avec joker *
    'category-*'  => ['admin', 'catalog-manager', 'super-admin'],
    'product-*'   => ['admin', 'catalog-manager', 'super-admin'],
    'brand-*'   => ['admin', 'catalog-manager', 'super-admin'],
];