<?php
include 'View/header.php'; // Inclure l'en-tête de la vue

// Affichage des messages de session
if (isset($_SESSION['error'])) {
    // Afficher le message d'erreur
    echo '<div class="alert alert-danger">' . $_SESSION['error'] . '</div>';
    unset($_SESSION['error']); // Supprimer le message de session après affichage
}
if (isset($_SESSION['success'])) {
    // Afficher le message de succès
    echo '<div class="alert alert-success">' . $_SESSION['success'] . '</div>';
    unset($_SESSION['success']); // Supprimer le message de session après affichage
}
?>

<div style="margin: 2% 15% 5% 15%">
    <h2> Connectez-vous !</h2>
    <!-- Formulaire de connexion -->
    <form method="POST" action="/login">
        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">@</span>
            <!-- Champ de saisie pour le nom d'utilisateur -->
            <input type="text" name="username" class="form-control" placeholder="Nom d'utilisateur"
                aria-label="Nom d'utilisateur" aria-describedby="basic-addon1">
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon2">🔒</span>
            <!-- Champ de saisie pour le mot de passe -->
            <input type="password" name="password" class="form-control" placeholder="Mot de passe"
                aria-label="Mot de passe" aria-describedby="basic-addon1">
        </div>
        <!-- Bouton de soumission du formulaire -->
        <button type="submit" class="btn btn-outline-secondary">Se connecter</button>
        <!-- Lien vers la page de réinitialisation du mot de passe -->
        <a class="btn" href="/forgotPassword">Mot de passe oublié ?</a>
    </form>
    <!-- Lien vers la page d'inscription -->
    <p> Si vous n'avez pas de compte vous pouvez vous inscrire :
    <a class="btn btn-outline-secondary" href="/register">S'inscrire </a>
</div>

<?php
include 'View/footer.php'; // Inclure le pied de page de la vue
?>
