<?php
    include 'View/header.php'; // Inclure l'en-tête de la vue

    // Affichage des messages d'erreur de session
    if (isset($_SESSION['error'])) {
        echo '<div class="alert alert-danger">' . $_SESSION['error'] . '</div>';
        unset($_SESSION['error']); // Supprimer le message de session après affichage
    }

    // Affichage des messages de succès de session
    if (isset($_SESSION['success'])) {
        echo '<div class="alert alert-success">' . $_SESSION['success'] . '</div>';
        unset($_SESSION['success']); // Supprimer le message de session après affichage
    }
?>
<!-- Formulaire de réinitialisation de mot de passe -->
<form method="POST" action="/forgotPassword">
    <label>Votre adresse mail</label>
    <input type="email" name="mail" placeholder="Email" required>
    <button type="submit" name="reset-password">Envoyer</button>
</form>

<?php
    include 'View/footer.php'; // Inclure le pied de page de la vue
?>
