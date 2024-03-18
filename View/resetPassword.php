<?php
    include 'View/header.php';
?>

<form action="/resetPassword" method="POST">
    <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
    <label for="new_password">Nouveau mot de passe :</label>
    <input type="password" id="new_password" name="new_password" required>
    
    <label for="new_password_c">Confirmer le nouveau mot de passe :</label>
    <input type="password" id="new_password_c" name="new_password_c" required>
    
    <button type="submit">Réinitialiser le mot de passe</button>
</form>

<?php
    include 'View/footer.php';
?>