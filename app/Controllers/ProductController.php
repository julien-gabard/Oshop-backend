<?php

namespace App\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Type;
use App\Models\Tag;

class ProductController extends CrudController {

    /**
     * Méthode liste des produits
     */
    public function list()
    {
        $this->show('product/list', [
            'productList' => Product::findAll(),
            'tokenCSRF' => $this->generateTokenCSRF(),
        ]);
    }

    /**
     * Méthode pour ajouter un produit
     */
    public function add()
    {
        $this->show('product/add-edit', [
            'product' => new Product(),
            'categories' => Category::findAll(),
            'brands' => Brand::findAll(),
            'types' => Type::findAll(),
            'tags' => Tag::findAll(),
            'tokenCSRF' => $this->generateTokenCSRF(),
        ]);
    }

    /**
     * Méthode pour éditer un produit
     */
    public function edit($id)
    {
        $product = Product::find($id);

        if (!$product) {
            $this->show('error/err404');
            return;
        }

        $this->show('product/add-edit', [
            'product' => $product,
            'categories' => Category::findAll(),
            'brands' => Brand::findAll(),
            'types' => Type::findAll(),
            'tagsList' => Tag::findAll(),
            'tags' => Tag::findTagByProduct($id),
            'tokenCSRF' => $this->generateTokenCSRF(),
        ]);
    }

    /**
     * Méthode pour créer un produit
     */
    public function createAndUpdate()
    {
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
        $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
        $picture = filter_input(INPUT_POST, 'picture', FILTER_VALIDATE_URL);
        $price = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT);
        $rate = filter_input(INPUT_POST, 'rate', FILTER_VALIDATE_INT);
        $status = filter_input(INPUT_POST, 'status', FILTER_VALIDATE_INT);
        $category_id = filter_input(INPUT_POST, 'category_id', FILTER_VALIDATE_INT);
        $brand_id = filter_input(INPUT_POST, 'brand_id', FILTER_VALIDATE_INT);
        $type_id = filter_input(INPUT_POST, 'type_id', FILTER_VALIDATE_INT);
        $tags = filter_input(INPUT_POST, 'tags', FILTER_VALIDATE_INT, FILTER_REQUIRE_ARRAY);
        
        $errorList = ErrorController::productError($name, $description, $picture, $price, $rate, $status, $category_id, $brand_id, $type_id);

        if (!empty($errorList)) {

            $product = new Product();

            $product->setName($_POST['name']);
            $product->setDescription($_POST['description']);
            $product->setPicture($_POST['picture']);
            $product->setPrice($_POST['price']);
            $product->setRate($_POST['rate']);
            $product->setStatus($_POST['status']);
            $product->setCategoryId($_POST['category_id']);
            $product->setBrandId($_POST['brand_id']);
            $product->setTypeId($_POST['type_id']);

            $this->show('product/add-edit', [
                'product' => $product,
                'errors' => $errorList,
                'categories' => Category::findAll(),
                'brands' => Brand::findAll(),
                'types' => Type::findAll()
            ]);

        } else {

            if (empty($_POST['id'])) {

                $pro = new Product();

                $pro->setName($name);
                $pro->setDescription($description);
                $pro->setPicture($picture);
                $pro->setPrice($price);
                $pro->setRate($rate);
                $pro->setStatus($status);
                $pro->setCategoryId($category_id);
                $pro->setBrandId($brand_id);
                $pro->setTypeId($type_id);

                $ok = $pro->insert();

                if ($ok) {
                
                    $success = 'Produit ajouter.';

                    $this->show('product/list', [
                        'success' => $success,
                        'productList' => Product::findAll()
                    ]);

                } else {
                
                    $errorList[] = 'Le produit n\'a pas été ajouter, veuillez réessayer.';

                    $this->show('product/add', [
                        'product' => $pro,
                        'errors' => $errorList,
                        'categories' => Category::findAll(),
                        'brands' => Brand::findAll(),
                        'types' => Type::findAll()
                    ]);
                }

            } else {

                $id = $_POST['id'];

                $pro = Product::find($id);

                $pro->setName($name);
                $pro->setDescription($description);
                $pro->setPicture($picture);
                $pro->setPrice($price);
                $pro->setRate($rate);
                $pro->setStatus($status);
                $pro->setCategoryId($category_id);
                $pro->setBrandId($brand_id);
                $pro->setTypeId($type_id);

                $ok = $pro->update();

                if ($ok) {

                    $success = 'Produit modifier.';

                    $this->show('product/list', [
                        'success' => $success,
                        'productList' => Product::findAll()
                    ]);

                } else {

                    $errorList[] = 'Échec de la modification, veuillez réessayer.';

                    $product = Product::find($id);

                    $this->show('product/add', [
                        'errors' => $errorList,
                        'product' => $product,
                    ]);
                }
            }
        }
    }

    /**
     * Méthode pour supprimer un produit
     */
    public function delete($id)
    {              
        $product = Product::find($id);

        $ok = $product->delete();
        
        if ($ok) {

            $success = 'Le produit a bien été supprimer';

            $this->show('product/list', [
                'success' => $success,
                'productList' => Product::findAll()
            ]);

        } else {

            $errorList[] = 'Le produit n\'a pas été supprimer';

            $this->show('product/list', [
                'productList' => Product::findAll()
            ]);

        }
    }

    /**
     * Méthode permettant de changer l'ordre des produits sur la page home.
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
                // Si on n'a pas d'erreur, alors on peut mettre à jour nos produits en base de données
                Product::setHomeSelection($emplacement);
                $_SESSION['flash'][] = 'Les produits mises en avant ont bien été mises à jour';
            }
            
            global $router;
            header('Location: '. $router->generate('product-homepage_selection'));
        }

        $this->show('product/homepageSelection', [
            'tokenCSRF' => $this->generateTokenCSRF(),
            'products' => Product::findAll(),
        ]);
    }
}