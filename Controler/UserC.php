<?php

namespace Controler;
use Model\UserModel;

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
        else{
            include 'View/register.php';
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
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['is_admin'] = $user['isAdmin']; // Supposons que 'isAdmin' est le champ qui indique si l'utilisateur est admin
                    
                    // Vérifier si l'utilisateur est un administrateur
                    if ($user['isAdmin']) {
                        // Redirige vers le back office pour les administrateurs
                        header('Location: index.php?uc=backoffice');
                    } else {
                        // Redirige vers la page d'accueil pour les utilisateurs
                        header('Location: index.php?uc=accueil');
                    }
                    exit(); // bonne pratique après un header
                } else {
                    echo "Identifiants incorrects.";
                }
            } else {
                echo "Veuillez remplir tous les champs.";
            }
        }
        else{
            include 'View/login.php';
        }
    }


}