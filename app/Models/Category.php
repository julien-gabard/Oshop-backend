<?php

namespace App\Models;

use App\Utils\Database;
use PDO;

class Category extends CoreModel {

    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $subtitle;
    /**
     * @var string
     */
    private $picture;
    /**
     * @var int
     */
    private $home_order;

    /**
     * Méthode permettant d'ajouter une catégorie dans la table category
     * 
     * @return bool
     */
    public function insert()
    {
        $pdo = Database::getPDO();

        $sql = 'INSERT INTO `category` (name, subtitle, picture)
                VALUES (:name, :subtitle, :picture)';

        $preparedQuery = $pdo->prepare($sql);
        $insertedRows = $preparedQuery->execute([
            ':name' => $this->name,
            ':subtitle' => $this->subtitle,
            ':picture' => $this->picture
        ]);

        if ($insertedRows > 0) {

            $this->id = $pdo->lastInsertId();
            return true;
        }
        
        return false;
    }

    /**
     * Méthode permettant de mettre à jours une catégorie dans la table category
     * 
     * @return bool
     */
    public function update()
    {
        $pdo = Database::getPDO();

        $sql = 'UPDATE `category`
                SET name = :name, 
                    subtitle = :subtitle, 
                    picture = :picture,
                    home_order = :homeOrder, 
                    updated_at = NOW()
                WHERE id = :id ';
        
        $pdoStatement = $pdo->prepare($sql);

        $pdoStatement->bindValue(':id', $this->id, PDO::PARAM_INT);
        $pdoStatement->bindValue(':name', $this->name, PDO::PARAM_STR);
        $pdoStatement->bindValue(':subtitle', $this->subtitle, PDO::PARAM_STR);
        $pdoStatement->bindValue(':picture', $this->picture, PDO::PARAM_STR);
        $pdoStatement->bindValue(':homeOrder', $this->home_order, PDO::PARAM_INT);

        return $pdoStatement->execute();
    }

    /**
     * Méthode permettant de supprimer une catégorie selon sont id
     */
    public function delete()
    {
        $pdo = Database::getPDO();

        $sql = "DELETE FROM `category`
                WHERE id = :id;
                ALTER TABLE `category` AUTO_INCREMENT = 1";

        $prepared = $pdo->prepare($sql);

        $deleteRows = $prepared->execute([
            ':id' => $this->id             
        ]);

        return ($deleteRows > 0);
    }

    /**
     * Méthode permettant de récupérer un enregistrement de la table Category en fonction d'un id donné
     * 
     * @param int $categoryId ID de la catégorie
     * @return Category
     */
    static public function find($categoryId)
    {
        // se connecter à la BDD
        $pdo = Database::getPDO();

        // écrire notre requête
        $sql = 'SELECT * 
                FROM `category` 
                WHERE `id` =' . $categoryId;

        // exécuter notre requête
        $pdoStatement = $pdo->query($sql);

        // un seul résultat => fetchObject
        $category = $pdoStatement->fetchObject('App\Models\Category');

        // retourner le résultat
        return $category;
    }

    /**
     * Méthode permettant de récupérer tous les enregistrements de la table category
     * 
     * @return Category[]
     */
    static public function findAll()
    {
        $pdo = Database::getPDO();
        $sql = 'SELECT * 
                FROM `category`';
        $pdoStatement = $pdo->query($sql);
        $results = $pdoStatement->fetchAll(PDO::FETCH_CLASS, 'App\Models\Category');
        
        return $results;
    }

    /**
     * Récupérer les 5 catégories mises en avant sur la home
     * 
     * @return Category[]
     */
    static public function findAllHomepage()
    {
        $pdo = Database::getPDO();
        $sql = 'SELECT *
                FROM category
                WHERE home_order > 0
                ORDER BY home_order 
                ASC';
        $pdoStatement = $pdo->query($sql);
        $categories = $pdoStatement->fetchAll(PDO::FETCH_CLASS, 'App\Models\Category');
        
        return $categories;
    }

    /**
     * Change l'orde de l'emplacement des id(s)
     */
    static public function setHomeSelection($emplacement)
    {
        $pdo = Database::getPDO();

        $sql = "UPDATE `category` SET home_order=:homeOrder";

        $query = $pdo->prepare($sql);
        $query->execute([':homeOrder' => 0]);

        $sql = "
            UPDATE `category` SET home_order = 1 WHERE id = :id1;
            UPDATE `category` SET home_order = 2 WHERE id = :id2;
            UPDATE `category` SET home_order = 3 WHERE id = :id3;
            UPDATE `category` SET home_order = 4 WHERE id = :id4;
            UPDATE `category` SET home_order = 5 WHERE id = :id5;
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
     * Get the value of subtitle
     */ 
    public function getSubtitle()
    {
        return $this->subtitle;
    }

    /**
     * Set the value of subtitle
     */ 
    public function setSubtitle($subtitle)
    {
        $this->subtitle = $subtitle;
    }

    /**
     * Get the value of picture
     */ 
    public function getPicture()
    {
        return $this->picture;
    }

    /**
     * Set the value of picture
     */ 
    public function setPicture($picture)
    {
        $this->picture = $picture;
    }
}
