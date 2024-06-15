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
    <h2> Inscrivez-vous !</h2>
    <!-- Formulaire d'inscription -->
    <form method="POST" action="/register" id="form">
        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">@</span>
            <!-- Champ de saisie pour le nom d'utilisateur -->
            <input type="text" name="username" class="form-control" placeholder="Nom d'utilisateur"
                aria-label="Nom d'utilisateur" aria-describedby="basic-addon1">
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon2">✉️</span>
            <!-- Champ de saisie pour l'email -->
            <input type="email" name="mail" class="form-control" placeholder="Email" aria-label="Email"
                aria-describedby="basic-addon1">
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon3">🔒</span>
            <!-- Champ de saisie pour le mot de passe -->
            <input type="password" name="password" class="form-control" placeholder="Mot de passe"
                aria-label="Mot de passe" aria-describedby="basic-addon1" id="password">
        </div>
        <div id="passwordRequirements"></div>
        <button type="submit" class="btn btn-outline-secondary">Créer un compte</button>
    </form>

    <!-- Inclusion de jQuery et script de validation de mot de passe -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function validatePassword() {
            var value = $('#password').val();
            var isPasswordValid = true;
            var errorMessage = '<br><h4>Le mot de passe doit suivre les règles suivantes : </h4>';

            // Vérification des critères de mot de passe
            if (value.length < 8) {
                errorMessage += '<ul><li>contenir au moins 8 caractères</li>';
                isPasswordValid = false;
            }
            if (!value.match(/[A-Z]/)) {
                errorMessage += '<li>contenir au moins une majuscule</li>';
                isPasswordValid = false;
            }
            if (!value.match(/[0-9]/)) {
                errorMessage += '<li>contenir au moins un chiffre</li>';
                isPasswordValid = false;
            }
            if (!value.match(/[a-z]/)) {
                errorMessage += '<li>contenir au moins une minuscule</li>';
                isPasswordValid = false;
            }
            if (!value.match(/[^a-zA-Z0-9]/)) {
                errorMessage += '<li>contenir au moins un caractère spécial</li></ul>';
                isPasswordValid = false;
            }
            if (!isPasswordValid) {
                // Afficher le message d'erreur si le mot de passe n'est pas valide
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

        // Événement sur la saisie du mot de passe pour valider en temps réel
        $('#password').on('input', validatePassword);
        // Événement sur la soumission du formulaire pour valider le mot de passe
        $('#form').on('submit', function (e) {
            if (!validatePassword()) {
                e.preventDefault();
            }
        });
    </script>
</div>

<?php
    include 'View/footer.php'; // Inclure le pied de page de la vue
?>
