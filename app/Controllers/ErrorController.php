<?php

namespace App\Controllers;

// Classe gérant les erreurs (404, 403, etc...)
class ErrorController extends CoreController {
    /**
     * Méthode gérant l'affichage de la page 404
     *
     * @return void
     */
    public function err404() {
        // On envoie le header 404
        header('HTTP/1.0 404 Not Found');

        // Puis on gère l'affichage
        $this->show('error/err404');
    }
    
    /**
     * Méthode gérant les érreurs du formulaire catégorie
     */
    public static function categoryError($name, $subtitle, $picture)
    {
        $errorList = [];

        if ($name === false) {
            $errorList[] = 'Le nom est invalide.';
        }
        if (empty($name)) {
            $errorList[] = 'Le nom ne doit pas être vide';
        }
        if ($subtitle === false) {
            $errorList[] = 'Le sous-titre est invalide.';
        }
        if (empty($subtitle)) {
            $errorList[] = 'Le sous-titre ne doit pas être vide';
        }
        if ($picture === false) {
            $errorList[] = 'L\'adresse de l\'image est invalide.';
        }

        if ($name===null || $subtitle===null || $picture===null) {
            $errorList[] = 'Y a eu un soucis technique';
        }

        return $errorList;
    }

    /**
     * Méthode gérant les érreurs du formulaire du produit
     */
    public static function productError($name, $description, $picture, $price, $rate, $status, $category_id, $brand_id, $type_id)
    {
        $errorList = [];

        if ($name === false) {
            $errorList[] = 'Le nom est invalide.';
        }
        if (empty($name)) {
            $errorList[] = 'Le nom ne doit pas être vide';
        }
        if ($description === false) {
            $errorList[] = 'La description est invalide.';
        }
        if (empty($description)) {
            $errorList[] = 'La description ne doit pas être vide';
        }
        if ($picture === false) {
            $errorList[] = 'L\'adresse de l\'image est invalide.';
        }
        if ($price === false) {
            $errorList[] = 'Le prix est invalide';
        }
        if ($rate === false) {
            $errorList[] = 'La note est invalide';
        }
        if ($status === false) {
            $errorList[] = 'Le statut est invalide';
        }
        if ($brand_id === false) {
            $errorList[] = 'La marque est invalide';
        }
        if ($category_id === false) {
            $errorList[] = 'La catégorie est invalide';
        }
        if ($type_id === false) {
            $errorList[] = 'Le type est invalide';
        }
        
        if ($name===null || $description===null || $picture===null || $price===null || $rate===null || $status===null || $brand_id===null || $category_id===null || $type_id===null) {
            $errorList[] = 'Y a eu un soucis technique';
        }
        
        return $errorList;
    }

    /**
     * Méthode gérant les erreurs du formulaire de création de compte
     */
    public static function createUserError($lastname, $firstname, $email, $password, $role, $status)
    {
        $errorList = [];

        if ($lastname === false) {
            $errorList[] = 'Le nom est invalide.';
        }
        if (empty($lastname)) {
            $errorList[] = 'Le nom ne doit pas être vide';
        }
        if ($firstname === false) {
            $errorList[] = 'Le prénom est invalide.';
        }
        if (empty($firstname)) {
            $errorList[] = 'Le prénom ne doit pas être vide';
        }
        if(!preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[-+!*$@%_])([-+!*$@%_\w]{8,15})$/', $password)) {
            $errorList[] = 'Le mot de passe doit contenir au moins 8 caractères dont au moins une majuscule, une minuscule, un chiffre et des caractères non alphanumeriques';
        }
        if ($password === false) {
            $errorList[] = 'Le mot de passe est invalide.';
        }
        if (empty($password)) {
            $errorList[] = 'Le mot de passe ne doit pas être vide.';
        }
        if ($email === false) {
            $errorList[] = 'L\'email est invalide.';
        }
        if ($role === false) {
            $errorList[] = 'Le role est invalide';
        }
        if ($status === false) {
            $errorList[] = 'Le status est invalide';
        }

        if ($lastname===null || $firstname===null || $email===null || $password===null ||$role===null || $status===null) {
            $errorList[] = 'Y a eu un soucis technique';
        }

        return $errorList;
    }

    /**
     * Méthode gérant les erreurs du formulaire de modification d'un utilisateur
     */
    public static function updateUserErr($firstname, $lastname, $email, $password, $role, $status)
    {
        $errorList = [];

        if ($firstname === false) {
            $errorList[] = 'Le prénom est invalide.';
        }
        if (empty($firstname)) {
            $errorList[] = 'Le prénom ne doit pas être vide';
        }
        if ($lastname === false) {
            $errorList[] = 'Le nom est invalide.';
        }
        if (empty($lastname)) {
            $errorList[] = 'Le nom ne doit pas être vide';
        }
        if ($email === false) {
            $errorList[] = 'L\'email est invalide.';
        }
        if (empty($email)) {
            $errorList[] = 'L\'email ne doit pas être vide';
        }
        if ($password === false) {
            $errorList[] = 'Le mot de passe est invalide.';
        }
        if (empty($password)) {
            $errorList[] = 'Le mot de passe ne doit pas être vide';
        }
        if ($role === false) {
            $errorList[] = 'Le rôle est invalide.';
        }
        if (empty($role)) {
            $errorList[] = 'Le rôle ne doit pas être vide';
        }
        if ($status === false) {
            $errorList[] = 'Le statut est invalide.';
        }
        if (empty($status)) {
            $errorList[] = 'Le statut ne doit pas être vide';
        }
        if ($firstname === null || $lastname === null || $password === null || $email === null || $role === null) {
            $errorList[] = 'Y a eu un soucis technique lol';
        }

        return $errorList;
    }

    /**
     * Méthode gérant les erreurs du formulaire de connexion
     */
    public static function loginError($password, $email, $currentUser)
    {
        $errorList = [];

        if (empty($password)) {

            $errorList[] = 'Veuillez saisir un mot de passe.';

        }
        if (empty($email)) {

            $errorList[] = 'Veuillez saisir une adresse email.';

        } else if ($currentUser === false) {

            $errorList[] = 'Email invalide !';

        }

        return $errorList;
    }
}