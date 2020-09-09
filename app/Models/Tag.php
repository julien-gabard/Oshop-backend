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

    /**
     * Méthode permettant d'ajouter un enregistrement dans la table tag
     * 
     * @return bool
     */
    public function insert()
    {
        $pdo = Database::getPDO();

        $sql = "
            INSERT INTO `tag` (name)
            VALUES ('{$this->name}')
        ";

        $insertedRows = $pdo->exec($sql);

        if ($insertedRows > 0) {
            
            $this->id = $pdo->lastInsertId();

            return true;
        }
        
        return false;
    }

    /**
     * Méthode permettant de mettre à jour un enregistrement dans la table tag
     * 
     * @return bool
     */
    public function update()
    {
        $pdo = Database::getPDO();

        $sql = "
            UPDATE `tag`
            SET
                name = '{$this->name}',
                updated_at = NOW()
            WHERE id = {$this->id}
        ";

        $updatedRows = $pdo->exec($sql);

        return ($updatedRows > 0);
    }

    /**
     * Méthode permettant de supprimer un tag selon sont id
     */
    public function delete()
    {
        $pdo = Database::getPDO();

        $sql = "DELETE FROM `tag`
                WHERE id = :id;
                ALTER TABLE `type` AUTO_INCREMENT = 1";

        $prepared = $pdo->prepare($sql);

        $deleteRows = $prepared->execute([
            ':id' => $this->id             
        ]);

        return ($deleteRows > 0);
    }
} 