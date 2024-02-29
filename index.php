<?php
session_start();
require_once 'Includes/pdo.php';

require_once 'Includes/TMDB.php';
require_once('vendor/autoload.php');

require 'Controler/UserC.php';
require 'Model/UserModel.php';

require 'Controler/MovieControler.php';
require 'Model/MovieModel.php';

$uc = filter_input(INPUT_GET, 'uc', FILTER_DEFAULT);

// Entête de la page
require 'View/header.php';

// Routage vers le contrôleur approprié en fonction de l'action demandée
switch ($uc) {
    case 'register':
        $userController = new Controler\UserC();
        $userController->register();
        break;
    case 'login':
        $userController = new Controler\UserC();
        $userController->login();
        break;
    case 'backoffice':
        include 'View/backOffice.php';
        break;
    case 'manageUser':
        $action = filter_input(INPUT_GET, 'action', FILTER_DEFAULT);
        $id = filter_input(INPUT_GET, 'id', FILTER_DEFAULT);

        if ($action === 'add') {
            $userController = new Controler\UserC();
            $userController->addUser();
        } elseif ($action === 'edit' && $id) {
            $userController = new Controler\UserC();
            $userController->editUser($id);
        }elseif ($action === 'delete' && $id) {
            $userController = new Controler\UserC();
            $userController->deleteUser($id);
        } else {
            $userController = new Controler\UserC();
            $userController->manageUsers();
        }
        break;
    case 'manageMovie':
        $action = filter_input(INPUT_GET, 'action', FILTER_DEFAULT);
        $id = filter_input(INPUT_GET, 'id', FILTER_DEFAULT);

        if ($action === 'add') {
            $movieController = new Controler\MovieControler();
            $movieController->addMovie($id);
        }else{
            $movieController = new Controler\MovieControler();
            $movieController->search();
        }
        break;
    case 'accueil':
    default: // Page d'accueil par défaut
        include 'Controler/AccueilC.php';
        break;
}
// Pied de la page
require 'View/footer.php';
?>