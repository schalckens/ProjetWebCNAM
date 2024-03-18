<?php
function checkUserLoggedIn()
{
    // Vérifie si la clé 'logged_in' existe dans la session et si elle est fausse ou non définie
    if (!isset ($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
        header('Location: /login');
        exit;
    }
}

function checkUserIsAdmin()
{
    // Vérifie si la clé 'is_admin' existe dans la session et si elle est fausse ou non définie
    if (!isset ($_SESSION['is_admin']) || $_SESSION['is_admin' !== true]) {
        header('location: /accueil');
        exit;
    }
}