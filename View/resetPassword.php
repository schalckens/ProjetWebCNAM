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
<main style="margin: 2% 15% 5% 15%">
    <!-- Formulaire de réinitialisation du mot de passe -->
    <form action="/resetPassword" method="POST" id="form">
        <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
        <label for="new_password">Nouveau mot de passe :</label>
        <input type="password" id="new_password" name="new_password" required>
        
        <label for="new_password_c">Confirmer le nouveau mot de passe :</label>
        <input type="password" id="new_password_c" name="new_password_c" required>
        
        <button type="submit">Réinitialiser le mot de passe</button>
    </form>
    <!-- Inclusion de jQuery et script de validation de mot de passe -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function validatePassword() {
            var password = $('#new_password').val();
            var confirmPassword = $('#new_password_c').val();
            var isPasswordValid = true;
            var errorMessage = 'Le mot de passe doit suivre les règles suivantes :';

            // Vérification des critères de mot de passe
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

        // Événement sur la saisie des mots de passe pour valider en temps réel
        $('#new_password, #new_password_c').on('input', validatePassword);
        // Événement sur la soumission du formulaire pour valider les mots de passe
        $('#form').on('submit', function(e) {
            if(!validatePassword()) {
                e.preventDefault();
            }
        });
    </script>
</main>

<?php
    include 'View/footer.php'; // Inclure le pied de page de la vue
?>
