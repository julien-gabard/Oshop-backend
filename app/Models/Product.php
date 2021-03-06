<?php

namespace App\Models;

use App\Utils\Database;
use PDO;

/**
 * Une instance de Product = un produit dans la base de données
 * Product hérite de CoreModel
 */
class Product extends CoreModel {
    
    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $description;
    /**
     * @var string
     */
    private $picture;
    /**
     * @var float
     */
    private $price;
    /**
     * @var int
     */
    private $rate;
    /**
     * @var int
     */
    private $status;
    /**
     * @var int
     */
    private $brand_id;
    /**
     * @var int
     */
    private $category_id;
    /**
     * @var int
     */
    private $type_id;

    /**
     * Méthode permettant d'ajouter un produit dans la table product
     * 
     * @return bool
     */
    public function insert()
    {
        $pdo = Database::getPDO();

        $sql = 'INSERT INTO `product` (name, description, picture, price, rate, status, category_id, brand_id, type_id)
                VALUES (:name, :description, :picture, :price, :rate, :status, :category_id, :brand_id, :type_id)';

        $preparedQuery = $pdo->prepare($sql);
        $insertedRows = $preparedQuery->execute([
            ':name' => $this->name,
            ':description' => $this->description,
            ':picture' => $this->picture,
            ':price' => $this->price,
            ':rate' => $this->rate,
            ':status' => $this->status,
            ':category_id' => $this->category_id,
            ':brand_id' => $this->brand_id,
            ':type_id' => $this->type_id
        ]);

        if ($insertedRows > 0) {

            $this->id = $pdo->lastInsertId();
            return true;
        }
        
        return false;
    }

    /**
     * Méthode permettant de mettre à jours un produit dans la table product
     * 
     * @return bool
     */
    public function update()
    {
        $pdo = Database::getPDO();

        $sql = 'UPDATE `product`
                SET name = :name, 
                    description = :description, 
                    picture = :picture, 
                    price = :price, 
                    rate = :rate,
                    status = :status,
                    category_id = :category_id,
                    brand_id = :brand_id,
                    type_id = :type_id,
                    updated_at = NOW()
                WHERE id = :id ';
        
        $pdoStatement = $pdo->prepare($sql);

        $pdoStatement->bindValue(':id', $this->id, PDO::PARAM_INT);
        $pdoStatement->bindValue(':name', $this->name, PDO::PARAM_STR);
        $pdoStatement->bindValue(':description', $this->description, PDO::PARAM_STR);
        $pdoStatement->bindValue(':picture', $this->picture, PDO::PARAM_STR);
        $pdoStatement->bindValue(':price', $this->price, PDO::PARAM_STR);
        $pdoStatement->bindValue(':rate', $this->rate, PDO::PARAM_STR);
        $pdoStatement->bindValue(':status', $this->status, PDO::PARAM_INT);
        $pdoStatement->bindValue(':brand_id', $this->brand_id, PDO::PARAM_INT);
        $pdoStatement->bindValue(':category_id', $this->category_id, PDO::PARAM_INT);
        $pdoStatement->bindValue(':type_id', $this->type_id, PDO::PARAM_INT);

        return $pdoStatement->execute();
    }

    /**
     * Méthode permettant de supprimer un produit selon sont id
     */
    public function delete()
    {
        $pdo = Database::getPDO();

        $sql = "DELETE FROM `product`
                WHERE id = :id;
                ALTER TABLE `product` AUTO_INCREMENT = 1";

        $prepared = $pdo->prepare($sql);

        $deleteRows = $prepared->execute([
            ':id' => $this->id             
        ]);

        return ($deleteRows > 0);
    }
    
    /**
     * Méthode permettant de récupérer un enregistrement de la table Product en fonction d'un id donné
     * 
     * @param int $productId ID du produit
     * @return Product
     */
    static public function find($productId)
    {
        // récupérer un objet PDO = connexion à la BDD
        $pdo = Database::getPDO();

        // on écrit la requête SQL pour récupérer le produit
        $sql = 'SELECT *
                FROM product
                WHERE id = ' . $productId;

        // query ? exec ?
        // On fait de la LECTURE = une récupration => query()
        // si on avait fait une modification, suppression, ou un ajout => exec
        $pdoStatement = $pdo->query($sql);

        // fetchObject() pour récupérer un seul résultat
        // si j'en avais eu plusieurs => fetchAll
        $result = $pdoStatement->fetchObject('App\Models\Product');
        
        return $result;
    }

    /**
     * Méthode permettant de récupérer tous les enregistrements de la table product
     * 
     * @return Product[]
     */
    static public function findAll()
    {
        $pdo = Database::getPDO();
        
        $sql = 'SELECT * 
                FROM `product`';

        $pdoStatement = $pdo->query($sql);
        $results = $pdoStatement->fetchAll(PDO::FETCH_CLASS, 'App\Models\Product');
        
        return $results;
    }

    /**
     * Méthode permettant de récupérer les enregistrements de la table product à mettre en home du BO
     * 
     * @return Product[]
     */
    static public function findAllHomepage()
    {
        $pdo = Database::getPDO();
        $sql = 'SELECT *
                FROM product
                WHERE home_order > 0
                ORDER BY home_order
                ASC';
        $pdoStatement = $pdo->query($sql);
        $results = $pdoStatement->fetchAll(PDO::FETCH_CLASS, 'App\Models\Product');
        
        return $results;
    }

    /**
     * Change l'orde de l'emplacement des id(s)
     */
    static public function setHomeSelection($emplacement)
    {
        $pdo = Database::getPDO();

        $sql = "UPDATE `product` SET home_order=:homeOrder";

        $query = $pdo->prepare($sql);
        $query->execute([':homeOrder' => 0]);

        $sql = "
            UPDATE `product` SET home_order = 1 WHERE id = :id1;
            UPDATE `product` SET home_order = 2 WHERE id = :id2;
            UPDATE `product` SET home_order = 3 WHERE id = :id3;
            UPDATE `product` SET home_order = 4 WHERE id = :id4;
            UPDATE `product` SET home_order = 5 WHERE id = :id5;
        ";

        $query = $pdo->prepare($sql);
        $query->execute([
            ':id1' => $emplacement[0],
            ':id2' => $emplacement[1],
            ':id3' => $emplacement[2],
            ':id4' => $emplacement[3],
            ':id5' => $emplacement[4],
        ]);
    }

    /**
     * Get the value of home_order
     */ 
    public function getHomeOrder()
    {
        return $this->home_order;
    }

    /**
     * Set the value of home_order
     */ 
    public function setHomeOrder($home_order)
    {
        $this->home_order = $home_order;
    }

    /**
     * Get the value of name
     *
     * @return  string
     */ 
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @param  string  $name
     */ 
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * Get the value of description
     *
     * @return  string
     */ 
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the value of description
     *
     * @param  string  $description
     */ 
    public function setDescription(string $description)
    {
        $this->description = $description;
    }

    /**
     * Get the value of picture
     *
     * @return  string
     */ 
    public function getPicture()
    {
        return $this->picture;
    }

    /**
     * Set the value of picture
     *
     * @param  string  $picture
     */ 
    public function setPicture(string $picture)
    {
        $this->picture = $picture;
    }

    /**
     * Get the value of price
     *
     * @return  float
     */ 
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set the value of price
     *
     * @param  float  $price
     */ 
    public function setPrice(float $price)
    {
        $this->price = $price;
    }

    /**
     * Get the value of rate
     *
     * @return  int
     */ 
    public function getRate()
    {
        return $this->rate;
    }

    /**
     * Set the value of rate
     *
     * @param  int  $rate
     */ 
    public function setRate(int $rate)
    {
        $this->rate = $rate;
    }

    /**
     * Get the value of status
     *
     * @return  int
     */ 
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set the value of status
     *
     * @param  int  $status
     */ 
    public function setStatus(int $status)
    {
        $this->status = $status;
    }

    /**
     * Get the value of brand_id
     *
     * @return  int
     */ 
    public function getBrandId()
    {
        return $this->brand_id;
    }

    /**
     * Set the value of brand_id
     *
     * @param  int  $brand_id
     */ 
    public function setBrandId(int $brand_id)
    {
        $this->brand_id = $brand_id;
    }

    /**
     * Get the value of category_id
     *
     * @return  int
     */ 
    public function getCategoryId()
    {
        return $this->category_id;
    }

    /**
     * Set the value of category_id
     *
     * @param  int  $category_id
     */ 
    public function setCategoryId(int $category_id)
    {
        $this->category_id = $category_id;
    }

    /**
     * Get the value of type_id
     *
     * @return  int
     */ 
    public function getTypeId()
    {
        return $this->type_id;
    }

    /**
     * Set the value of type_id
     *
     * @param  int  $type_id
     */ 
    public function setTypeId(int $type_id)
    {
        $this->type_id = $type_id;
    }
}
