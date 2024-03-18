<?php
    include 'View/header.php';
?>

<form action="/resetPassword" method="POST" id="form">
    <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
    <label for="new_password">Nouveau mot de passe :</label>
    <input type="password" id="new_password" name="new_password" required>
    
    <label for="new_password_c">Confirmer le nouveau mot de passe :</label>
    <input type="password" id="new_password_c" name="new_password_c" required>
    
    <button type="submit">Réinitialiser le mot de passe</button>
</form>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function validatePassword() {
        var password = $('#new_password').val();
        var confirmPassword = $('#new_password_c').val();
        var isPasswordValid = true;
        var errorMessage = 'Le mot de passe doit suivre les règles suivantes :';

        if(password !== confirmPassword) {
            errorMessage += '<br>- Les deux mots de passe doivent correspondre';
            isPasswordValid = false;
        }
        if(password.length < 8) {
            errorMessage += '<br>- Contenir au moins 8 caractères';
            isPasswordValid = false;
        }
        if(!password.match(/[A-Z]/)) {
            errorMessage += '<br>- Contenir au moins une majuscule';
            isPasswordValid = false;
        }
        if(!password.match(/[0-9]/)) {
            errorMessage += '<br>- Contenir au moins un chiffre';
            isPasswordValid = false;
        }
        if(!password.match(/[a-z]/)) {
            errorMessage += '<br>- Contenir au moins une minuscule';
            isPasswordValid = false;
        }
        if(!password.match(/[^a-zA-Z0-9]/)) {
            errorMessage += '<br>- Contenir au moins un caractère spécial';
            isPasswordValid = false;
        }
        if(!isPasswordValid) {
            if ($('.error').length) {
                $('.error').html(errorMessage);
            } else {
                $('#form').append('<div class="error">' + errorMessage + '</div>');
            }
            return false;
        } else {
            $('.error').remove();
            return true;
        }
    }

    $('#new_password, #new_password_c').on('input', validatePassword);
    $('#form').on('submit', function(e) {
        if(!validatePassword()) {
            e.preventDefault();
        }
    });
</script>

<?php
    include 'View/footer.php';
?>
