<?php

namespace App\Controllers;

use App\Models\Brand;

class BrandController extends CoreController {

    /**
     * Méthode permettant d'afficher la liste des marques
     */
    public function list()
    {
        $this->show('brand/list', [
            'brands' => Brand::findAll(),
            'tokenCSRF' => $this->generateTokenCSRF(),
        ]);
    }

    /**
     * Méthode pour ajouter une marque
     */
    public function add()
    {
        $this->show('brand/add-edit', [
            'brand' => new Brand(),
            'tokenCSRF' => $this->generateTokenCSRF(),
        ]);
    }

    /**
     * Méthode pour éditer une marque
     */
    public function edit($id)
    {
        $brand = Brand::find($id);

        if (!$brand) {
            $this->show('error/err404');
            return;
        }

        $this->show('brand/add-edit', [
            'brand' => $brand,
            'tokenCSRF' => $this->generateTokenCSRF(),
        ]);
    }

    /**
     * Méthode pour créer et modifier une marque dans la BDD
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

            $brand = new Brand();

            $brand->setName($_POST['name']);

            $this->show('brand/add-edit', [
                'brand' => $brand,
                'errors' => $errorList
            ]);

        } else {

            if (empty($_POST['id'])) {

                $brand = new Brand();

                $brand->setName($name);

                $ok = $brand->insert();

                if ($ok) {
                
                    header("Location: /brand/list");

                } else {
                
                    $errorList[] = 'La marque n\'a pas été ajouter, veuillez réessayer.';
                
                    $this->show('brand/add-edit', [
                        'brand' => $brand,
                        'errors' => $errorList
                    ]);
                }

            } else {

                $id = $_POST['id'];

                $brand = Brand::find($id);

                $brand->setName($name);

                $ok = $brand->update();

                if ($ok) {

                    header("Location: /brand/list");

                } else {

                    $errorList[] = 'Échec de la modification, veuillez réessayer.';

                    $this->show('brand/add-edit', [
                        'errors' => $errorList,
                        'brand' => $brand,
                    ]);
                }
            }
        }
    }

    /**
     * Méthode pour supprimer une marque
     */
    public function delete($id)
    {
        $brand = Brand::find($id);

        $ok = $brand->delete();

        if ($ok) {

            header("Location: /brand/list");

        } else {

            $errorList[] = 'La marque n\'a pas été supprimer';

            $this->show('brand/list', [
                'errors' => $errorList,
                'brands' => Brand::findAll()
            ]);

        }

    }
}