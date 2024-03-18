<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Site de Jeux de Films</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Lien vers la feuille de style CSS -->
    <link rel="stylesheet" href="styles/style.css">
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbar" aria-controls="navbar" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <a class="navbar-brand" href="/accueil">Nom App</a>
                
                <div class="navbar-collapse collapse" id="navbar">
                    <ul class="navbar-nav">
                    <?php if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true): ?>
                        <li class="nav-item"><a class="nav-link" href="/login">Connexion</a></li>
                        <li class="nav-item"><a class="nav-link" href="/register">Inscription</a></li>
                    <?php elseif (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] == 0): ?>
                        <li class="nav-item"><a class="nav-link" href="/game">Jeu</a></li>
                        <li class="nav-item"><a class="nav-link" href="/disconnect">Déconnexion</a></li>
                    <?php else: ?>
                        <li class="nav-item"><a class="nav-link" href="/backoffice">Back Office</a></li>
                        <li class="nav-item"><a class="nav-link" href="/game">Jeu</a></li>
                        <li class="nav-item"><a class="nav-link" href="/disconnect">Déconnexion</a></li>
                    <?php endif; ?>
                    </ul>
                    <!-- <div class="navbar-nav">
                        <a class="nav-link active" aria-current="page" href="/login">Connexion</a>
                        <a class="nav-link" href="/disconnect">Déconnexion</a>
                        <a class="nav-link disabled" aria-disabled="true">Déconnexion</a>
                    </div> -->
                </div>
            </div>
        </nav>
    </header>