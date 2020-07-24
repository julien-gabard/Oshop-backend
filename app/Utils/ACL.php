<?php

namespace App\Utils;

abstract class ACL
{
    /**
     * Trouve les rôles requis pour une route précise, ou un ensemble de routes.
     * 
     * Exemple :
     * 
     *    - la route "category-edit" match la clé d'ACL "category-edit" mais aussi "category-*"
     *    - si les ACL définissent des rôles requis pour l'un ou l'autre
     *    - alors la route "category-edit" va matcher dans les deux cas
     *
     * @param string $routeName
     * @return bool
     */
    static public function findForRoute($routeName)
    {
        global $acl;
        $filtered = array_filter($acl, function($key) use($routeName) {
            if ($key[-1] === '*') $key = substr($key, 0, -2);
            $pattern = "/^$key/";
            // dump($pattern);
            $res = preg_match($pattern, $routeName);
            // dump($res);
            return $res;
        }, ARRAY_FILTER_USE_KEY);
        // dump('---');
        // dump($filtered);
        // dump('---');
        return empty($filtered) ? false : [
            'acl'   =>   array_keys($filtered)[0],
            'roles' => array_values($filtered)[0]
        ];
    }
} 