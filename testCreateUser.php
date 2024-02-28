<?php

require_once 'C:/wamp64/www/ProjetWebCNAM/Includes/pdo.php';
require_once 'C:/wamp64/www/ProjetWebCNAM/Model/UserModel.php'; 

use Model\UserModel;

$userModel = new UserModel();

$username = "testUser";
$mail = "test@test.com";
$isAdmin = 0;
$password = "test";

$success = $userModel->create($username, $mail, $isAdmin, $password);

if ($success) {
    echo "Utilisateur créé avec succès.\n";
} else {
    echo "Échec de la création de l'utilisateur.\n";
}
