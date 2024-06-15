<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Site de Jeux de Films</title>
    <!-- Inclusion de Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Inclusion des styles spécifiques de Bootstrap -->
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <!-- Inclusion de Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body data-bs-theme="dark">
    <div>
        <header>
            <!-- Barre de navigation -->
            <nav class="navbar navbar-expand-lg" style="background-color:#1b2b3b;">
                <div class="container-fluid">
                    <!-- Bouton de basculement de la barre de navigation pour les petits écrans -->
                    <button 
                        class="navbar-toggler" 
                        type="button" 
                        data-bs-toggle="collapse"
                        data-bs-target="#navbar1" 
                        aria-controls="navbar1" 
                        aria-expanded="false"
                        aria-label="Toggle navigation"
                    >
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    
                    <!-- Logo et titre du site -->
                    <a class="navbar-brand" href="/accueil">
                        <img src="View/imgs/c3.png" alt="logo" width="30" height="30"> DetectiveDuCinéma
                    </a>

                    <!-- Menu de navigation -->
                    <div class="collapse navbar-collapse" id="navbar1">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <!-- Vérification de la session pour afficher les liens appropriés -->
                        <?php if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true): ?>
                            <li class="nav-item"><a class="nav-link" href="/login">Connexion</a></li>
                            <li class="nav-item"><a class="nav-link" href="/register">Inscription</a></li>
                        <?php elseif (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] == 0): ?>
                            <li class="nav-item"><a class="nav-link" href="/game">Jeu</a></li>
                            <li class="nav-item"><a class="nav-link" href="/disconnect">Déconnexion</a></li>
                        <?php else: ?>
                            <li class="nav-item"><a class="nav-link active" aria-current="page" href="/backoffice">Back Office</a></li>
                            <li class="nav-item"><a class="nav-link active" aria-current="page" href="/game">Jeu</a></li>
                            <li class="nav-item"><a class="nav-link active" aria-current="page" href="/disconnect">Déconnexion</a></li>
                        <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </nav>
        </header>
    </div>
