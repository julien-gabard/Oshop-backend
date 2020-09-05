<?php

namespace App\Controllers;

use App\Models\Type;

class TypeController extends CoreController {

    /**
     * Méthode permettant d'afficher la liste des types.
     */
    public function list()
    {
        $this->show('type/list', [
            'types' => Type::findAll(),
            'tokenCSRF' => $this->generateTokenCSRF(),
        ]);
    }
}

?>