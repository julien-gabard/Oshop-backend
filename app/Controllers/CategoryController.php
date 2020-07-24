<?php

namespace App\Controllers;

use App\Models\Category;

class CategoryController extends CrudController {

    /**
     * Méthode liste des catégories
     */
    public function list()
    {
        $this->show('category/list', [
            'categoryList' => Category::findAll(),
            'tokenCSRF' => $this->generateTokenCSRF(),
        ]);
    }
    
    /**
     * Méthode pour ajouter une catégorie
     */
    public function add()
    {
        $this->show('category/add-edit', [
            'category' => new Category(),
            'tokenCSRF' => $this->generateTokenCSRF(),
        ]);
    }

    /**
     * Méthode pour éditer une catégorie
     */
    public function edit($id)
    {
        $category = Category::find($id);

        if (!$category) {
            $this->show('error/err404');
            return;
        }

        $this->show('category/add-edit', [
            'category' => $category,
            'tokenCSRF' => $this->generateTokenCSRF(),
        ]);
    }

    /**
     * Méthode pour créer et modifier une catégorie dans la BDD
     */
    public function createAndUpdate()
    {
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
        $subtitle = filter_input(INPUT_POST, 'subtitle', FILTER_SANITIZE_STRING);
        $picture = filter_input(INPUT_POST, 'picture', FILTER_VALIDATE_URL);
        
        $errorList = ErrorController::categoryError($name, $subtitle, $picture);

        if (!empty($errorList)) {

            $category = new Category();

            $category->setName($_POST['name']);
            $category->setSubtitle($_POST['subtitle']);
            $category->setPicture($_POST['picture']);

            $this->show('category/add-edit', [
                'category' => $category,
                'errors' => $errorList
            ]);

        } else {

            if (empty($_POST['id'])) {

                $cat = new Category();

                $cat->setName($name);
                $cat->setSubtitle($subtitle);
                $cat->setPicture($picture);

                $ok = $cat->insert();

                if ($ok) {
                
                    $success = 'Catégorie ajouter.';

                    $this->show('category/list', [
                        'success' => $success,
                        'categoryList' => Category::findAll()
                    ]);

                } else {
                
                    $errorList[] = 'La catégorie n\'a pas été ajouter, veuillez réessayer.';
                
                    $this->show('category/add-edit', [
                        'category' => $cat,
                        'errors' => $errorList
                    ]);
                }

            } else {

                $id = $_POST['id'];

                $cat = Category::find($id);

                $cat->setName($name);
                $cat->setSubtitle($subtitle); 
                $cat->setPicture($picture);

                $ok = $cat->update();

                if ($ok) {

                    header("Location: /category/$id/edit?success=ok");

                } else {

                    $errorList[] = 'Échec de la modification, veuillez réessayer.';

                    $category = Category::find($id);

                    $this->show('category/add-edit', [
                        'errors' => $errorList,
                        'category' => $category,
                    ]);
                }
            }
        }
    }

    /**
     * Méthode pour supprimer une catégorie
     */
    public function delete($id)
    {
        $category = Category::find($id);

        $ok = $category->delete();

        if ($ok) {

            $success = 'La catégorie a bien été supprimer';

            $this->show('category/list', [
                'success' => $success,
                'categoryList' => Category::findAll()
            ]);

        } else {

            $errorList[] = 'La catégorie n\'a pas été supprimer';

            $this->show('category/list', [
                'categoryList' => Category::findAll()
            ]);

        }

    }

    /**
     * Méthode permettant de changer l'ordre des catégorie sur la page home.
     */
    public function homepageSelection()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $emplacement = filter_input(INPUT_POST, 'emplacement', FILTER_VALIDATE_INT, FILTER_REQUIRE_ARRAY);

            $errorList = [];

            if (in_array(false, $emplacement)) {
                $errorList[] = 'Les données reçues ne sont pas correctes. Veuillez recommencer.';
            }

            // On vérfie ensuite qu'aucune erreur n'a été détectée
            if (count($errorList) == 0) {
                // Si on n'a pas d'erreur, alors on peut mettre à jour nos catégories en base de données
                Category::setHomeSelection($emplacement);
                $_SESSION['flash'][] = 'Les catégories mises en avant ont bien été mises à jour';
            }
            // On est en POST et on souhaiterait que le formulaire ne s'affiche qu'en GET
            // pour des raisons de UX (expérience utilisateur)
            // et pour éviter de refaire des requêtes SQL inutiles
            // On peut donc rediriger vers la page sur laquelle on est actuellement mais en GET
            global $router;
            header('Location: '. $router->generate('category-homepage_selection'));
        }

        $this->show('category/homepageSelection', [
            'tokenCSRF' => $this->generateTokenCSRF(),
            'categories' => Category::findAll(),
        ]);
    }
}