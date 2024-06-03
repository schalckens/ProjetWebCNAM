<?php
    include 'View/header.php';
// Affichage des messages de session
if (isset($_SESSION['error'])) {
    echo '<div class="alert alert-danger">' . $_SESSION['error'] . '</div>';
    unset($_SESSION['error']);
}
if (isset($_SESSION['success'])) {
    echo '<div class="alert alert-success">' . $_SESSION['success'] . '</div>';
    unset($_SESSION['success']);
}
?>
<form method="POST" action="/forgotPassword">
    <label>Votre adresse mail</label>
    <input type="email" name="mail" placeholder="Email" required>
    <button type="submit" name="reset-password">Envoyer</button>
</form>

<?php
    include 'View/footer.php';
?>