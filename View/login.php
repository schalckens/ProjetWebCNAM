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


<div style="margin: 2% 15% 5% 15%">
    <h2> Connectez-vous !</h2>
    <form method="POST" action="/login">
        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">@</span>
            <input type="text" name="username" class="form-control" placeholder="Nom d'utilisateur"
                aria-label="Nom d'utilisateur" aria-describedby="basic-addon1">
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon2">🔒</span>
            <input type="password" name="password" class="form-control" placeholder="Mot de passe"
                aria-label="Nom d'utilisateur" aria-describedby="basic-addon1">
        </div>
        <button type="submit" class="btn btn-outline-secondary">Se connecter</button>
        <a class="btn" href="/forgotPassword">Mot de passe oublié ?</a>
    </form>
    <p> Si vous n'avez pas de compte vous pouvez vous inscrire :
    <a class="btn btn-outline-secondary" href="/register">S'inscrire </a>
</div>


<?php
include 'View/footer.php';
?>