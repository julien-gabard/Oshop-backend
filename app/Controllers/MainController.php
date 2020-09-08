<?php

namespace App\Controllers;

// Si j'ai besoin du Model Category
use App\Models\Category;
use App\Models\Product;

class MainController extends CoreController {

    /**
     * Méthode s'occupant de la page d'accueil
     *
     * @return void
     */
    public function home()
    {
        $placement = 1;
        // On appelle la méthode show() de l'objet courant
        // En argument, on fournit le fichier de Vue
        // Par convention, chaque fichier de vue sera dans un sous-dossier du nom du Controller
        // En paramétre on fournit la méthode "findAllHomepage" pour afficher les mises en avant
        $this->show('main/home', [
            'categoryHomePage' => Category::findAllHomepage(),
            'productHomePage' => Product::findAllHomepage(),
            'placement' => $placement
        ]);
    }
}
