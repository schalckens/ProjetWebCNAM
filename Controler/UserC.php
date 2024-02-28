<?php

namespace Controler;

class UserC
{
    private $userModel;

    public function __construct(PDO $db)
    {
        $this->userModel = new UserModel($db);
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? null;
            $mail = $_POST['mail'] ?? null;
            $mdp = $_POST['mdp'] ?? null;

            if ($username && $mail && $mdp) {
                $isAdmin = false; // Par défaut, l'utilisateur n'est pas un administrateur.
                $this->userModel->create($username, $mail, $isAdmin, $mdp);
                // Rediriger vers la page de connexion ou afficher un message de succès.
                echo "Compte créé avec succès. Vous pouvez maintenant vous connecter.";
            } else {
                echo "Veuillez remplir tous les champs.";
            }
        }
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? null;
            $mdp = $_POST['mdp'] ?? null;

            if ($username && $mdp) {
                // Cette méthode n'existe pas encore dans UserModel. Elle doit être implémentée.
                $user = $this->userModel->findByUsername($username);
                if ($user && password_verify($mdp, $user['mdp'])) {
                    // Authentifier l'utilisateur (par exemple, enregistrer ses données dans $_SESSION).
                    echo "Connexion réussie.";
                } else {
                    echo "Identifiants incorrects.";
                }
            } else {
                echo "Veuillez remplir tous les champs.";
            }
        }
    }


}