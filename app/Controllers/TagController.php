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

    /**
     * Méthode pour ajouter un tag.
     */
    public function add()
    {
        $this->show('tag/add-edit', [
            'tag' => new Tag(),
            'tokenCSRF' => $this->generateTokenCSRF(),
        ]);
    }

    /**
     * Méthode pour éditer un tag
     */
    public function edit($id)
    {
        $tag = Tag::find($id);

        if (!$tag) {
            $this->show('error/err404');
            return;
        }

        $this->show('tag/add-edit', [
            'tag' => $tag,
            'tokenCSRF' => $this->generateTokenCSRF(),
        ]);
    }

    /**
     * Méthode pour créer et modifier un tag dans la BDD
     */
    public function createAndUpdate()
    {
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
        
        $errorList = [];

        if ($name === false) {
            $errorList[] = 'Le nom est invalide.';
        }
        if (empty($name)) {
            $errorList[] = 'Le nom ne doit pas être vide';
        }

        if (!empty($errorList)) {

            $tag = new Tag();

            $tag->setName($_POST['name']);

            $this->show('tag/add-edit', [
                'tag' => $tag,
                'errors' => $errorList
            ]);

        } else {

            if (empty($_POST['id'])) {

                $tag = new Tag();

                $tag->setName($name);

                $ok = $tag->insert();

                if ($ok) {
                
                    $success = 'Tag ajouter';

                    $this->show('tag/list', [
                        'success' => $success,
                        'tags' => Tag::findAll()
                    ]);

                } else {
                
                    $errorList[] = 'Le tag n\'a pas été ajouter, veuillez réessayer.';
                
                    $this->show('tag/add-edit', [
                        'tag' => $tag,
                        'errors' => $errorList
                    ]);
                }

            } else {

                $id = $_POST['id'];

                $tag = Tag::find($id);

                $tag->setName($name);

                $ok = $tag->update();

                if ($ok) {

                    $success = 'Tag modifier';

                    $this->show('tag/list', [
                        'success' => $success,
                        'tags' => Tag::findAll()
                    ]);

                } else {

                    $errorList[] = 'Échec de la modification, veuillez réessayer.';

                    $this->show('brand/add-edit', [
                        'errors' => $errorList,
                        'tag' => $tag,
                    ]);
                }
            }
        }
    }

    /**
     * Méthode pour supprimer un tag
     */
    public function delete($id)
    {
        $tag = Tag::find($id);

        $ok = $tag->delete();

        if ($ok) {

            $success = 'Le tag a bien été supprimer';

            $this->show('tag/list', [
                'success' => $success,
                'tags' => Tag::findAll()
            ]);

        } else {

            $errorList[] = 'Le tag n\'a pas été supprimer';

            $this->show('tag/list', [
                'errors' => $errorList,
                'tasg' => Tag::findAll()
            ]);

        }

    }
}

?>