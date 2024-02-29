<?php
session_start();
require_once 'Includes/pdo.php';

require_once 'Includes/TMDB.php';
require_once('vendor/autoload.php');

require 'Controler/UserC.php';
require 'Model/UserModel.php';
require 'router.php';
require 'Controler/MovieControler.php';
require 'Model/MovieModel.php';

// Entête de la page
require 'View/header.php';

// Création d'une instance du routeur
$router = new Router();


// Obtention de l'instance du contrôleur
$userController = new Controler\UserC();
$movieController = new Controler\MovieControler();

// Définition des routes

$router->addRoute('GET', '/', function() {
    include 'View/accueil.php';
});
$router->addRoute('GET', '/login', function() {
    include 'View/login.php';
});
$router->addRoute('POST', '/login', function() use ($userController) {
    $userController->login();
});
$router->addRoute('GET', '/register', function() {
    include 'View/register.php';
});
$router->addRoute('POST', '/register', function() use ($userController) {
    $userController->register();
});
$router->addRoute('GET', '/accueil', function() {
    include 'View/accueil.php';
});
// Affiche la page de gestion des utilisateurs
$router->addRoute('GET', '/manageUser', function() use ($userController) {
    $userController->manageUsers();
});

// Ajoute un utilisateur
$router->addRoute('POST', '/manageUser/add', function() use ($userController) {
    $userController->addUser();
});

// Modifie un utilisateur
$router->addRoute('GET', '/manageUser/edit/:id', function($id) use ($userController) {
    $userController->editUser($id);
});
$router->addRoute('POST', '/manageUser/edit/:id', function($id) use ($userController) {
    $userController->editUser($id);
});


// Supprime un utilisateur
$router->addRoute('GET', '/manageUser/delete/:id', function($id) use ($userController) {
    $userController->deleteUser($id);
});
$router->addRoute('GET', '/backoffice', function() {
    include 'View/backOffice.php';
});

$router->addRoute('GET', '/manageMovie', function() {
    include 'View/manageMovie.php';
});
$router->addRoute('GET', '/manageMovie/add/:id', function($id) use ($movieController) {
    $movieController->addMovie($id);
});
$router->addRoute('POST', '/manageMovie/add/:id', function($id) use ($movieController) {
    $movieController->addMovie($id);
});
$router->addRoute('POST', '/manageMovie', function() use ($movieController) {
    $movieController->search();
});

try {
    $router->matchRoute();
} catch (Exception $e) {
    // Gestion des erreurs si aucune route ne correspond
    echo "Erreur : " . $e->getMessage();
}
// Pied de la page
require 'View/footer.php';
?>