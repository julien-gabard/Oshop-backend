<?php

namespace App\Controllers;

use \App\Models\AppUser;
use \App\Utils\ACL;

abstract class CoreController {

    public function __construct()
    {
        $this->currentUser = isset($_SESSION['currentUser']) ? $_SESSION['currentUser'] : new AppUser();

        // ---- Gestion de ACL ----

        global $acl;

        global $match;
        $routeName = $match['name'];

        $aclMatch = ACL::findForRoute($routeName);
        
        if ($aclMatch) {
            $this->checkAuthorization($aclMatch['roles']);
        }

        // ---- Gestion de CSRF ----

        global $csrf;

        // Si la route actuelle nécessite la vérification d'un token anti-CSRF,
        // que ce soit en GET ou en POST, on récupère et vérifie le token.
        if (!empty($csrf) && in_array($routeName, $csrf) && $_SERVER['REQUEST_METHOD'] == 'POST') {

            // On a potentiellement récupéré un token CSRF, on en vérifie la validité.
            $this->checkTokenCSRF();
        }
    }

    /**
     * Méthode permettant d'afficher du code HTML en se basant sur les views
     *
     * @param string $viewName Nom du fichier de vue
     * @param array $viewVars Tableau des données à transmettre aux vues
     * @return void
     */
    protected function show(string $viewName, $viewVars = []) {
        // On globalise $router car on ne sait pas faire mieux pour l'instant
        global $router;

        // Comme $viewVars est déclarée comme paramètre de la méthode show()
        // les vues y ont accès
        // ici une valeur dont on a besoin sur TOUTES les vues
        // donc on la définit dans show()
        $viewVars['currentPage'] = $viewName;

        $splitted = preg_split("/\//", $viewName);
        $viewVars['controllerName'] = $splitted[0];
        $viewVars['actionName'] = $splitted[0];

        // définir l'url absolue pour nos assets
        $viewVars['assetsBaseUri'] = $_SERVER['BASE_URI'] . '/assets/';
        $absoluteUrl = isset($_SERVER['BASE_URI']) ? $_SERVER['BASE_URI'] : '';
        // définir l'url absolue pour la racine du site
        // /!\ != racine projet, ici on parle du répertoire public/
        $viewVars['baseUri'] = $_SERVER['BASE_URI'];

        $viewVars['currentUser'] = $this->currentUser;

        // On veut désormais accéder aux données de $viewVars, mais sans accéder au tableau
        // La fonction extract permet de créer une variable pour chaque élément du tableau passé en argument
        extract($viewVars);
        // => la variable $currentPage existe désormais, et sa valeur est $viewName
        // => la variable $assetsBaseUri existe désormais, et sa valeur est $_SERVER['BASE_URI'] . '/assets/'
        // => la variable $baseUri existe désormais, et sa valeur est $_SERVER['BASE_URI']
        // => il en va de même pour chaque élément du tableau

        // $viewVars est disponible dans chaque fichier de vue
        require_once __DIR__.'/../views/layout/header.tpl.php';
        require_once __DIR__.'/../views/'.$viewName.'.tpl.php';
        require_once __DIR__.'/../views/layout/footer.tpl.php';
    }

    protected function route($path, $data = []) {
        global $router;
        return $router->generate($path, $data);
    }

    /**
     * Vérification des droits de l'utilisateur courant à faire, ou pas, quelque chose.
     *
     * @param $roles une liste de rôles requis pour laisser l'utilisateur courant poursuivre son chemin.
     * @return bool
     */
    public function checkAuthorization($roles = []) {

        if ($this->currentUser->exist()) {
            
            $userRole = $this->currentUser->getRole();
            
            if (in_array($userRole, $roles)) {

                return true;
            } else {
                
                $this->err403();

                exit;
            }

        } else {
            
            global $router;
            header('Location: ' . $router->generate('login'));
            exit;
        }
    }

    public function err403() {
        // On envoie le header 403 Forbidden
        http_response_code(403);

        // Puis on gère l'affichage
        $this->show('error/err403');
    }

    public function generateTokenCSRF()
    {
        $token = md5(getmypid().'-skouleCSRF*'.time().'toto'.mt_rand(1000,10000000));

        $_SESSION['tokenCSRF'] = $token;

        return $token;
    }

    public function checkTokenCSRF()
    {
        // 1. Vérifier la présence du token
        $proposal = $_POST['tokenCSRF'] ?? $_GET['tokenCSRF'] ?? '';

        // 2. Vérifier la validité du token proposé.
        if ($proposal !== $_SESSION['tokenCSRF']) {

            $this->show('error/err403');
            exit;
        }
    }
}
