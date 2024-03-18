<?php
    include 'View/header.php';
?>

<form method="POST" action="/login">
    <a href="/register">S'inscrire</a>
    <div class="input-group mb-3">
        <span class="input-group-text" id="basic-addon1">@</span>
        <input type="text" name="username" class="form-control" placeholder="Nom d'utilisateur"
            aria-label="Nom d'utilisateur" aria-describedby="basic-addon1">
    </div>
    <div class="input-group mb-3">
        <span class="input-group-text" id="basic-addon1">🔒</span>
        <input type="password" name="password" class="form-control" placeholder="Mot de passe"
            aria-label="Nom d'utilisateur" aria-describedby="basic-addon1">
    </div>
    <button type="submit">Se connecter</button>
    <a href="/forgotPassword">Mot de passe oublié ?</a>
</form>

<?php
    include 'View/footer.php';
?>