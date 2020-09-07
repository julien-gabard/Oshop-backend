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

    /**
     * Méthode pour ajouter un type.
     */
    public function add()
    {
        $this->show('type/add-edit', [
            'type' => new Type(),
            'tokenCSRF' => $this->generateTokenCSRF(),
        ]);
    }

    /**
     * Méthode pour éditer un type
     */
    public function edit($id)
    {
        $type = Type::find($id);

        if (!$type) {
            $this->show('error/err404');
            return;
        }

        $this->show('type/add-edit', [
            'type' => $type,
            'tokenCSRF' => $this->generateTokenCSRF(),
        ]);
    }

    /**
     * Méthode pour créer et modifier un type dans la BDD
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

            $type = new Type();

            $type->setName($_POST['name']);

            $this->show('type/add-edit', [
                'type' => $type,
                'errors' => $errorList
            ]);

        } else {

            if (empty($_POST['id'])) {

                $type = new Type();

                $type->setName($name);

                $ok = $type->insert();

                if ($ok) {
                
                    header("Location: /type/list");

                } else {
                
                    $errorList[] = 'Le type n\'a pas été ajouter, veuillez réessayer.';
                
                    $this->show('type/add-edit', [
                        'type' => $type,
                        'errors' => $errorList
                    ]);
                }

            } else {

                $id = $_POST['id'];

                $type = Type::find($id);

                $type->setName($name);

                $ok = $type->update();

                if ($ok) {

                    header("Location: /type/list");

                } else {

                    $errorList[] = 'Échec de la modification, veuillez réessayer.';

                    $this->show('brand/add-edit', [
                        'errors' => $errorList,
                        'type' => $type,
                    ]);
                }
            }
        }
    }

    /**
     * Méthode pour supprimer un type
     */
    public function delete($id)
    {
        $type = Type::find($id);

        $ok = $type->delete();

        if ($ok) {

            header("Location: /type/list");

        } else {

            $errorList[] = 'La marque n\'a pas été supprimer';

            $this->show('brand/list', [
                'errors' => $errorList,
                'types' => Type::findAll()
            ]);

        }

    }
}

?>