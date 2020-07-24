<?php

namespace App\Controllers;

use App\Models\AppUser;

class AppUserController extends CoreController
{
    /**
     * Méthode pour afficher la page créer un compte
     */
    public function add()
    {
        $this->show('user/add-edit', [
            'user' => new AppUser(),
            'tokenCSRF' => $this->generateTokenCSRF(),
        ]);
    }

    /**
     * Méthode pour afficher la page modifier un utilisateur
     */
    public function edit($appUserId)
    {
        $user = AppUser::find($appUserId);

        $this->show('user/add-edit', [
            'user' => $user,
            'tokenCSRF' => $this->generateTokenCSRF(),
        ]);
    }

    /**
     * Méthode pour ajouter un utilisateur dans la BDD
     */
    public function create()
    {
        $lastname = filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_STRING);
        $firstname = filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_STRING);
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
        $role = filter_input(INPUT_POST, 'role', FILTER_SANITIZE_STRING);
        $status = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_NUMBER_INT);

        $errorList = ErrorController::createUserError($lastname, $firstname, $email, $password, $role, $status);

        if (!empty($errorList)) {

            $user = new AppUser();

            $user->setLastname($_POST['lastname']);
            $user->setFirstname($_POST['firstname']);
            $user->setEmail($_POST['email']);
            $user->setRole($_POST['role']);
            $user->setStatus($_POST['status']);

            $this->show('user/add-edit', [
                'user' => $user,
                'errors' => $errorList
            ]);

        } else {

            $user = new AppUser();

            $user->setLastname($lastname);
            $user->setFirstname($firstname);
            $user->setEmail($email);
            $user->setPassword($password);
            $user->setRole($role);
            $user->setStatus($status);
            
            $ok = $user->insert();

            if ($ok) {

                $location = $this->route('user-list');
                header("Location: $location");
                
            } else {
                
                $errorList[] = 'La création du compte a échoué, veuillez réessayer.';
                
                $this->show('user/add-edit', [
                    'user' => $user,
                    'errors' => $errorList,
                ]);
            }
        }
    }

    /**
     * Méthode pour modifier un utilisateur dans la BDD
     */
    public function update($appUserId)
    {
        $firstname = filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_STRING);
        $lastname = filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_STRING);
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
        $role = filter_input(INPUT_POST, 'role', FILTER_SANITIZE_STRING);
        $status = filter_input(INPUT_POST, 'status', FILTER_VALIDATE_INT);

        $errorList = ErrorController::updateUserErr($firstname, $lastname, $email, $password, $role, $status);

        if (!empty($errorList)) {

            $user = new AppUser();

            $user->setFirstName($_POST['firstname']);
            $user->setLastName($_POST['lastname']);
            $user->setEmail($_POST['email']);
            $user->setPassword($_POST['password']);
            $user->setRole($_POST['role']);
            $user->setStatus($_POST['status']);

            $this->show('user/add-edit', [
                'user' => $user,
                'errors' => $errorList
            ]);

        } else {

            $user = AppUser::find($appUserId);

            $user->setFirstName($firstname);
            $user->setLastName($lastname);
            $user->setEmail($email);
            $user->setPassword($password);
            $user->setRole($role);
            $user->setStatus($status);

            $ok = $user->update();

            if ($ok) {

                $location = $this->route('user-list');
                header("Location: $location");

            } else {
                
                $errorList[] = 'La sauvegarde a échoué, veuillez réessayer.';
                
                $this->show("user/add-edit", [
                  'user' => $user,
                  'errors' => $errorList
                ]);
            }
        }
    }

    /**
     * Méthode pour supprimer un utilisateur
     */
    public function delete($appUserId)
    {
        $user = AppUser::find($appUserId);

        if ($user) {

            $user->delete();

            $location = $this->route('user-list');
            header("Location: $location");

        } else {
            http_response_code(404);
        }
    }

    /**
     * Méthode permettant d'afficher la liste des utilisateurs
     */
    public function list()
    {
        $users = AppUser::findAll();

        $this->show('user/list', [
            'users' => $users,
            'tokenCSRF' => $this->generateTokenCSRF(),
        ]);
    }

    public function info($appUserId) {
        http_response_code(501);
    }
}