<?php

namespace App\Models;

use App\Utils\Database;
use PDO;

class Tag extends CoreModel
{
    private $name;

    /**
     * Get the value of name
     */ 
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */ 
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @param int $tagId ID du tag
     * @return Tag
     */
    public static function find($tagId)
    {
        $pdo = Database::getPDO();

        $sql = 'SELECT * 
                FROM `tag` 
                WHERE `id` =' . $tagId;

        $pdoStatement = $pdo->query($sql);

        $results = $pdoStatement->fetchObject('App\Models\Tag');

        return $results;
    }

    /**
     * Méthode permettant de récupérer tous les enregistrements de la table tag
     * 
     * @return Tag[]
     */
    public static function findAll()
    {
        $pdo = Database::getPDO();

        $sql = 'SELECT * 
                FROM `tag`';

        $pdoStatement = $pdo->query($sql);
        $results = $pdoStatement->fetchAll(PDO::FETCH_CLASS, 'App\Models\Tag');

        return $results;
    }

    /**
     * Méthode permettant de récupérer tous les tags lier au produit
     * 
     * @return Tag[]
     */
    public static function findTagByProduct($productId)
    {
        $pdo = Database::getPDO();

        $sql = 'SELECT
                    tag.name AS tag_name,
                    product.name AS product_name,
                    product.id AS product_id
                FROM
                    tag
                INNER JOIN product_tag ON tag.id = product_tag.tag_id
                INNER JOIN product ON product.id = product_tag.product_id
                WHERE product.id =' . $productId;

        $pdoStatement = $pdo->query($sql);

        $results = $pdoStatement->fetchAll(PDO::FETCH_CLASS, 'App\Models\Tag');

        return $results;
    }
} 