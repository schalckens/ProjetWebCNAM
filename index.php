<?php
session_start();
require_once 'Includes/pdo.php';
require 'Controler/UserC.php';
require 'Model/UserModel.php';

$uc = filter_input(INPUT_GET, 'uc', FILTER_DEFAULT);

// Entête de la page
// require 'View/v_header.php';

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
    case 'accueil':
    default: // Page d'accueil par défaut
        include 'Controler/AccueilC.php';
        break;
}
// Pied de la page
// require 'View/v_footer.php';
?>