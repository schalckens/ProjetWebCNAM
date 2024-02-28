<?php

namespace Controler;
use Model\UserModel;
use PdoProjetWeb;

class UserC
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? null;
            $mail = $_POST['mail'] ?? null;
            $password = $_POST['password'] ?? null;

            if ($username && $mail && $password) {
                $isAdmin = false; // Par défaut, l'utilisateur n'est pas un administrateur.
                $this->userModel->create($username, $mail, $isAdmin, $password);
                echo "Compte créé avec succès. Vous pouvez maintenant vous connecter.";
                header('Location: index.php?uc=accueil'); // Redirige vers la page de connexion
            } else {
                echo "Veuillez remplir tous les champs.";
            }
        }
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? null;
            $password = $_POST['password'] ?? null;

            if ($username && $password) {
                // Cette méthode n'existe pas encore dans UserModel. Elle doit être implémentée.
                $user = $this->userModel->findByUsername($username);
                if ($user && password_verify($password, $user['password'])) {
                    $_SESSION['user_id'] = $user['id'];
                    echo "Connexion réussie.";
                    header('Location: index.php?uc=accueil'); // Redirige vers la page d'accueil
                } else {
                    echo "Identifiants incorrects.";
                }
            } else {
                echo "Veuillez remplir tous les champs.";
            }
        }
    }


}