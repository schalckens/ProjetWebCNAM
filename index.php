<?php
session_start();
require_once 'Includes/pdo.php';

require_once 'Includes/TMDB.php';
require_once 'Includes/functions.php';
require_once('vendor/autoload.php');

require 'Controller/UserController.php';
require 'Model/UserModel.php';
require 'router.php';
require 'Controller/MovieController.php';
require 'Controller/GameController.php';
require 'Model/MovieModel.php';
require 'Model/GenreModel.php';
require 'Model/DirectorModel.php';
require 'Model/CountryModel.php';
require 'Model/ProductionCompanyModel.php';
require 'Model/ActorModel.php';


// Création d'une instance du routeur
$router = new Router();


// Obtention de l'instance du contrôleur
$userController = new Controller\UserController();
$movieController = new Controller\MovieController();
$gameController = new Controller\GameController();

// Définition des routes

// Affiche la page d'accueil
$router->addRoute('GET', '/', function () {
    include 'View/accueil.php';
});
$router->addRoute('GET', '/accueil', function () {
    include 'View/accueil.php';
});

// Affiche la page de connexion
$router->addRoute('GET', '/login', function () {
    include 'View/login.php';
});
$router->addRoute('POST', '/login', function () use ($userController) {
    $userController->login();
});

$router->addRoute('GET', '/disconnect', function () use ($userController) {
    $userController->logout();
});



$router->addRoute('GET', '/forgotPassword', function () {
    include 'View/forgotPassword.php';
});
$router->addRoute('POST', '/forgotPassword', function () use ($userController) {
    // Récupère l'email à partir des données POST
    if (isset ($_POST['mail'])) {
        $email = $_POST['mail'];
        $userController->sendPasswordResetEmail($email);
    } else {
        echo "Email manquant.";
    }
});
$router->addRoute('GET', '/resetPassword/:token', function ($token) {
    include 'View/resetPassword.php';
});

$router->addRoute('POST', '/resetPassword', function () use ($userController) {
    if (isset($_POST['new_password_c']) && isset($_POST['token'])) {
        $password = $_POST['new_password_c'];
        $token = $_POST['token'];
        $userController->resetPassword($token, $password);
    } else {
        echo "Email manquant.";
    }
});

// Affiche la page d'inscription
$router->addRoute('GET', '/register', function () {
    include 'View/register.php';
});
$router->addRoute('POST', '/register', function () use ($userController) {
    $userController->register();
});

// Page de vérification mail
$router->addRoute('GET', '/verify/:token', function ($token) use ($userController) {
    $userController->verifyEmail($token);
});


// Affiche la page de gestion des utilisateurs
$router->addRoute('GET', '/manageUser', function () use ($userController) {
    checkUserIsAdmin();
    $userController->manageUsers();
});

// Ajoute un utilisateur
$router->addRoute('POST', '/manageUser/add', function () use ($userController) {
    checkUserIsAdmin();
    $userController->addUser();
});

// Modifie un utilisateur
$router->addRoute('GET', '/manageUser/edit/:id', function ($id) use ($userController) {
    checkUserIsAdmin();
    $userController->editUser($id);
});
$router->addRoute('POST', '/manageUser/edit/:id', function ($id) use ($userController) {
    checkUserIsAdmin();
    $userController->editUser($id);
});


// Supprime un utilisateur
$router->addRoute('GET', '/manageUser/delete/:id', function ($id) use ($userController) {
    checkUserIsAdmin();
    $userController->deleteUser($id);
});
$router->addRoute('GET', '/backoffice', function () {
    checkUserIsAdmin();
    include 'View/backOffice.php';
});

$router->addRoute('GET', '/manageMovie', function () use ($movieController) {
    checkUserIsAdmin();
    $movieController->manageMovies();
    //include 'View/manageMovie.php';
});

$router->addRoute('GET', '/game', function () use ($gameController) {
    checkUserLoggedIn();
    $_SESSION['randomMovie'] = $gameController->getRandomMovie();
    include 'View/game.php';
});

// Recherche de films par nom
$router->addRoute('GET', '/gameMovie/search/:userInput', function ($userInput) use ($movieController) {
    checkUserLoggedIn();
    $inputDecoded = urldecode($userInput);
    $movieController->getMoviesByInput($inputDecoded);
});

$router->addRoute('GET', '/gameMovie/getMovieDetails/:userInput', function ($userInput) use ($movieController) {
    checkUserLoggedIn();
    $inputDecoded = urldecode($userInput);
    echo json_encode($movieController->getMovieDetails($inputDecoded));
});

$router->addRoute('GET', '/gameMovie/compareMovie/:movieName', function ($movieName) use ($gameController) {
    checkUserLoggedIn();
    $movieNameDecoded = urldecode($movieName);
    $gameController->compareMovie($movieNameDecoded);
});

$router->addRoute('GET', '/gameMovie/getCurrentMovie', function () use ($gameController) {
    checkUserLoggedIn();
    echo json_encode($gameController->getCurrentMovie());
});

// Ajoute un film
$router->addRoute('GET', '/manageMovie/add/:id', function ($id) use ($movieController) {
    checkUserIsAdmin();
    $movieController->addMovie($id);
});
$router->addRoute('POST', '/manageMovie/add/:id', function ($id) use ($movieController) {
    checkUserIsAdmin();
    $movieController->addMovie($id);
});

// Cherche des films
$router->addRoute('POST', '/manageMovie', function () use ($movieController) {
    checkUserIsAdmin();
    $movieController->search();
    //include 'View/manageMovie.php';
});
$router->addRoute('GET', '/manageMovie/clearSearch', function () use ($movieController) {
    checkUserIsAdmin();
    $movieController->clearSearch();
});

$router->addRoute('GET', '/manageMovie/delete/:id', function ($id) use ($movieController) {
    checkUserIsAdmin();
    $movieController->deleteMovie($id);
});

// API pour récupérer la liste des utilisateurs
$router->addRoute('GET', '/api/users', function () use ($userController) {
    $userController->getAllUsers();
});

// API pour récupérer un utilisateur par ID
$router->addRoute('GET', '/api/users/:id', function ($id) use ($userController) {
    $userController->getUserById($id);
});
try {
    $router->matchRoute();
} catch (Exception $e) {
    // Gestion des erreurs si aucune route ne correspond
    echo "Erreur : " . $e->getMessage();
}
?>