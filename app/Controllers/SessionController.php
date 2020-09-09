<?php

namespace App\Controllers;

use App\Models\AppUser;

class SessionController extends CoreController
{
    /**
     * Méthode pour afficher la page connexion
     */
    public function login()
    {  
        $this->show('session/login', [
            'tokenCSRF' => $this->generateTokenCSRF(),
            'user' => new AppUser()
        ]);
    }

    /**
     * Méthode pour récupérer les données de $_POST de connexion et vérifier si ces données correspond aux données de la BDD
     */
    public function authenticate()
    {
        // Je récupère les inputs du formulaire de connexion
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
        
        // je récupère le résultat de findByEmail($email).
        // Renvoie false si pas trouvé ou renvoie une instance de app_user
        $currentUser = AppUser::findByEmail($email);

        $errorList = ErrorController::loginError($password, $email, $currentUser);
        
        if ($currentUser) {

            if (password_verify($password, $currentUser->getPassword())) {

                $_SESSION['currentUser'] = $currentUser;
                $_SESSION['currentUserId'] = $currentUser->getId();


                header("location: /");
    
            } else {

                $errorList[] = 'Mot de passe invalide !';
            }
        }

        $this->show('session/login', [
            'user' => $currentUser,
            'errors' => $errorList,
            'tokenCSRF' => $this->generateTokenCSRF()
        ]);
    }

    /**
     * Méthode pour déconnecter l'utilsateur
     */
    public function logout()
    {
        unset($_SESSION['currentUser']);
        unset($_SESSION['currentUserId']);
        header("Location: {$this->route('login')}");;
    }
}