<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Site de Jeux de Films</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Lien vers la feuille de style CSS -->
    <link rel="stylesheet" href="styles/style.css">
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <button 
                    class="navbar-toggler" 
                    type="button" 
                    data-toggle="collapse"
                    data-target="#navbar1" 
                    aria-controls="navbar1" 
                    aria-expanded="false"
                    aria-label="Toggle navigation"
                >
                    <span class="navbar-toggler-icon"></span>
                </button>
                
                
                <div class="collapse navbar-collapse" id="navbar1">
                    <a class="navbar-brand" href="/accueil">  <span class="fa fa-home"></span> Nom App</a>
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <?php if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true): ?>
                        <li class="nav-item"><a class="nav-link active" aria-current="page" href="/login">Connexion</a></li>
                        <li class="nav-item"><a class="nav-link active" aria-current="page" href="/register">Inscription</a></li>
                    <?php elseif (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true): ?>
                        <li class="nav-item"><a class="nav-link active" aria-current="page" href="/game">Jeu</a></li>
                        <li class="nav-item"><a class="nav-link active" aria-current="page" href="/disconnect">Déconnexion</a></li>
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