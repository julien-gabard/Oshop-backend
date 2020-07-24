<?php

namespace App\Models;

use App\Utils\Database;
use PDO;

class AppUser extends CoreModel {

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $password;

    /**
     * @var string
     */
    private $firstname;

    /**
     * @var string
     */
    private $lastname;

    /**
     * @var ?
     */
    private $role;

    /**
     * @var int
     */
    private $status;

    /**
     * Méthode permettant de comparer l'email avec l'email de la table App_user
     * 
     * @param $email
     * @return AppUser[] | False
     */
    static public function findByEmail($email)
    {
        $pdo = Database::getPDO();

        $sql = 'SELECT *
                FROM `app_user`
                WHERE `email`
                LIKE :email';

        // Je prépare ma requête
        $pdoStatement = $pdo->prepare($sql);
        // J'associe une valeur à :email
        $pdoStatement->bindValue(':email', $email, PDO::PARAM_STR);
        // J'excute bindValue
        $pdoStatement->execute();
        // Je retourne le resultat si ok un objet sinon false
        $result = $pdoStatement->fetchObject('App\Models\AppUser');
        
        return $result;
    }

    /**
     * Méthode permettant d'ajouter un utilisateur dans la table App_user
     * 
     * @return bool
     */
    public function insert()
    {
        $pdo = Database::getPDO();

        $sql = 'INSERT INTO `app_user` (email, firstname, lastname, password, role, status)
                VALUES (:email, :firstname, :lastname, :password, :role, :status)';

        $pdoStatement = $pdo->prepare($sql);

        $pdoStatement->bindValue(':email', $this->email, PDO::PARAM_STR);
        $pdoStatement->bindValue(':firstname', $this->firstname, PDO::PARAM_STR);
        $pdoStatement->bindValue(':lastname', $this->lastname, PDO::PARAM_STR);
        $pdoStatement->bindValue(':password', $this->password, PDO::PARAM_STR);
        $pdoStatement->bindValue(':role', $this->role, PDO::PARAM_STR);
        $pdoStatement->bindValue(':status', $this->status, PDO::PARAM_INT);

        $ok = $pdoStatement->execute();

        if ($pdoStatement->rowCount() > 0) {

            $this->id = $pdo->lastInsertId();

            return true;

        }

        return false;
    }

    /**
     * Méthode permettant de mettre à jours un utilisateur dans la table App_user
     * 
     * @return bool
     */
    public function update()
    {
        $pdo = Database::getPDO();

        $sql = 'UPDATE `app_user`
                SET lastname = :lastname,
                    firstname = :firstname,
                    email = :email, 
                    password = :password, 
                    status = :status,
                    role = :role,
                    updated_at = NOW()
                WHERE id = :id ';
        
        $pdoStatement = $pdo->prepare($sql);

        $pdoStatement->bindValue(':id', $this->id, PDO::PARAM_INT);
        $pdoStatement->bindValue(':email', $this->email, PDO::PARAM_STR);
        $pdoStatement->bindValue(':password', $this->password, PDO::PARAM_STR);
        $pdoStatement->bindValue(':firstname', $this->firstname, PDO::PARAM_STR);
        $pdoStatement->bindValue(':lastname', $this->lastname, PDO::PARAM_STR);
        $pdoStatement->bindValue(':status', $this->status, PDO::PARAM_INT);
        $pdoStatement->bindValue(':role', $this->role, PDO::PARAM_STR);

        $ok = $pdoStatement->execute();

        return ($pdoStatement->rowCount() > 0);
    }

    /**
     * Méthode permettant de supprimer un enregistrement dans la table app_user
     * 
     * @return bool
     */
    public function delete()
    {
        // Récupération de l'objet PDO représentant la connexion à la DB
        $pdo = Database::getPDO();

        // Ecriture de la requête UPDATE
        $sql = "DELETE FROM `app_user`
                WHERE id = :id;
                ALTER TABLE `app_user` AUTO_INCREMENT = 1";

        // Préparation de la requête de mise à jour (pas exec, pas query)
        // Bon, ici, on aurait pu utiliser exec car l'id ne peut venir que de la base de données, il est donc "sécurisé"
        $pdoStatement = $pdo->prepare($sql);

        // On bind chaque jeton/token/placeholder
        $pdoStatement->bindValue(':id', $this->id, PDO::PARAM_INT);

        // On exécute la requête préparée
        $ok = $pdoStatement->execute();

        // On retourne VRAI, si au moins une ligne supprimée
        return ($pdoStatement->rowCount() > 0);
    }

    /**
     * Méthode permettant de récupérer un enregistrement de la table app_user en fonction d'un id donnée
     * 
     * @param int
     * @return App_user
     */
    public function find($appUserId)
    {
        $pdo = Database::getPDO();

        $sql = 'SELECT * 
                FROM `app_user` 
                WHERE `id` =' . $appUserId;

        $pdoStatement = $pdo->query($sql);
        $item = $pdoStatement->fetchObject(self::class);

        // retourner le résultat
        return $item ;
    }

    /**
     * Méthode permettant de récupérer tous les enregistrements de la table app_user
     * 
     * @return AppUser[]
     */
    public static function findAll()
    {
        $pdo = Database::getPDO();

        $sql = 'SELECT * FROM `app_user`';

        $pdoStatement = $pdo->query($sql);
        $results = $pdoStatement->fetchAll(PDO::FETCH_CLASS, self::class);
        
        return $results;
    }

    /**
     * Get the value of email
     *
     * @return  string
     */ 
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @param  string  $email
     */ 
    public function setEmail(string $email)
    {
        $this->email = $email;
    }

    /**
     * Get the value of password
     *
     * @return  string
     */ 
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @param  string  $password
     */ 
    public function setPassword(string $password)
    {
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }

    /**
     * Get the value of firstname
     *
     * @return  string
     */ 
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set the value of firstname
     *
     * @param  string  $firstname
     */ 
    public function setFirstname(string $firstname)
    {
        $this->firstname = $firstname;
    }

    /**
     * Get the value of lastname
     *
     * @return  string
     */ 
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set the value of lastname
     *
     * @param  string  $lastname
     */ 
    public function setLastname(string $lastname)
    {
        $this->lastname = $lastname;
    }

    /**
     * Get the value of role
     *
     * @return  string
     */ 
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set the value of role
     *
     * @param  string  $role
     */ 
    public function setRole(string $role)
    {
        return $this->role = $role;
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
     * Méthode qui retourne si oui ou non cet utilisateur existe réellement en BDD.
     */
    public function exist()
    {
        return $this->getId() > 0;
    }

    public function isAdmin() : bool
    {
        return $this->getRole() === 'admin';
    }

    public function isCatalogManager() : bool
    {
        return $this->getRole() === 'catalog-manager';
    }

    public function isSuperAdmin() : bool
    {
        return $this->getRole() === 'super-admin';
    }

    public function isActive() : bool
    {
        return $this->getStatus() === '1';
    }
}