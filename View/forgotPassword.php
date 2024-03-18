<?php
    include 'View/header.php';
?>

<form method="POST" action="/forgotPassword">
    <label>Votre adresse mail</label>
    <input type="email" name="mail" placeholder="Email" required>
    <button type="submit" name="reset-password">Envoyer</button>
</form>

<?php
    include 'View/footer.php';
?>