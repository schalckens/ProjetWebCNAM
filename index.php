<?php
session_start();

$uc = filter_input(INPUT_GET, 'uc', FILTER_DEFAULT);

$estConnecte = estConnecte();

// Entête de la page
// require 'View/v_header.php';

// Si l'utilisateur n'est pas connecté, force la connexion
if ($uc && !$estConnecte) {
    $uc = 'connexion';
} elseif (empty($uc)) {
    $uc = 'accueil'; // Page d'accueil par défaut
}

// Routage vers le contrôleur approprié en fonction de l'action demandée
switch ($uc) {
    case 'connexion':
        include 'Controleur/c_connexion.php';
        break;
    case 'accueil':
    default: // Page d'accueil par défaut
        include 'Controleur/c_accueil.php';
        break;
}
// Pied de la page
// require 'View/v_footer.php';
?>