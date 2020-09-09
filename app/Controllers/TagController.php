<?php

namespace App\Controllers;

use App\Models\Tag;

class TagController extends CoreController {

    /**
     * Méthode permettant d'afficher la liste des tags.
     */
    public function list()
    {
        $this->show('tag/list', [
            'tags' => Tag::findAll(),
            'tokenCSRF' => $this->generateTokenCSRF(),
        ]);
    }
}

?>