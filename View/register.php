<?php
include 'View/header.php';
?>
<div class="container">
    <h2> Inscrivez-vous !</h2>
    <form method="POST" action="/register" id="form">
        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">@</span>
            <input type="text" name="username" class="form-control" placeholder="Nom d'utilisateur"
                aria-label="Nom d'utilisateur" aria-describedby="basic-addon1">
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon2">✉️</span>
            <input type="email" name="mail" class="form-control" placeholder="Email" aria-label="Email"
                aria-describedby="basic-addon1">
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon3">🔒</span>
            <input type="password" name="password" class="form-control" placeholder="Mot de passe"
                aria-label="Mot de passe" aria-describedby="basic-addon1" id="password">
        </div>
        <div id="passwordRequirements"></div>
        <button type="submit" class="btn btn-outline-secondary">Créer un compte</button>
    </form>
<div>
<div class="container">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function validatePassword() {
            var value = $('#password').val();
            var isPasswordValid = true;
            var errorMessage = '<br><h4>Le mot de passe doit suivre les règles suivantes : </h4>';

            if (value.length < 8) {
                errorMessage += '<ul><li>contenir au moins 8 caractères</li>';
                isPasswordValid = false;
            }
            if (!value.match(/[A-Z]/)) {
                errorMessage += '<li> contenir au moins une majuscule </li>';
                isPasswordValid = false;
            }
            if (!value.match(/[0-9]/)) {
                errorMessage += '<li> contenir au moins un chiffre </li>';
                isPasswordValid = false;
            }
            if (!value.match(/[a-z]/)) {
                errorMessage += '<li> contenir au moins une minuscule </li>';
                isPasswordValid = false;
            }
            if (!value.match(/[^a-zA-Z0-9]/)) {
                errorMessage += '<li> contenir au moins un caractère spécial </li></ul>';
                isPasswordValid = false;
            }
            if (!isPasswordValid) {
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

        $('#password').on('input', validatePassword);
        $('#form').on('submit', function (e) {
            if (!validatePassword()) {
                e.preventDefault();
            }
        });
    </script>
</div>

<?php
    include 'View/footer.php';
?>