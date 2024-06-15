<?php
    include 'View/header.php'; // Inclure l'en-tête de la vue
?>

<div style="margin: 2% 15% 5% 15%">
    <h2>Modifier l'Utilisateur</h2>
    <!-- Formulaire de modification de l'utilisateur -->
    <form action="/manageUser/edit/<?php echo htmlspecialchars($user['id']); ?>" method="post" id="form">
        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">@</span>
            <!-- Champ de saisie pour le nom d'utilisateur -->
            <input type="text" name="username" class="form-control" placeholder="Nom d'utilisateur"
                aria-label="Nom d'utilisateur" aria-describedby="basic-addon1" value="<?php echo htmlspecialchars($user['username']); ?>" required>
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon2">✉️</span>
            <!-- Champ de saisie pour l'email -->
            <input type="email" name="mail" class="form-control" placeholder="Email" aria-label="Email"
                aria-describedby="basic-addon1" value="<?php echo htmlspecialchars($user['mail']); ?>" required>
        </div>
        <div class="form-check">
            <!-- Checkbox pour définir l'utilisateur comme administrateur -->
            <label class="form-check-label" for="isAdmin">Administrateur:</label>
            <input class="form-check-input" type="checkbox" id="isAdmin" name="isAdmin" <?php echo $user['isAdmin'] ? 'checked' : ''; ?>>
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon3">🔒</span>
            <!-- Champ de saisie pour le mot de passe -->
            <input type="password" name="password" class="form-control" placeholder="Mot de passe"
                aria-label="Mot de passe" aria-describedby="basic-addon1" id="password">
        </div>
        <div class="form-check">
            <!-- Checkbox pour indiquer si l'email est vérifié -->
            <label class="form-check-label" for="is_verified">Mail vérifié:</label>
            <input class="form-check-input" type="checkbox" id="is_verified" name="is_verified" <?php echo $user['is_verified'] ? 'checked' : ''; ?>>
        </div>
        <!-- Bouton pour soumettre le formulaire -->
        <button type="submit" class="btn btn-outline-secondary">Mettre à jour</button>
    </form>
</div>

<div style="margin: 2% 15% 5% 15%">
    <!-- Script jQuery pour valider le mot de passe -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function validatePassword() {
            var value = $('#password').val();
            if (value === '') {
                // Si le champ mot de passe est vide, ne pas valider et considérer comme valide 
                return true;
            }
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

        // Écouteur d'événements pour valider le mot de passe en temps réel
        $('#password').on('input', validatePassword);
        // Écouteur d'événements pour valider le mot de passe lors de la soumission du formulaire
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
