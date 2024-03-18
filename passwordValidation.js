function validatePassword() {
    var value = $('#password').val();
    var isPasswordValid = true;
    var errorMessage = 'Le mot de passe doit suivre les règles suivantes :';

    if(value.length < 8) {
        errorMessage += '<br>- Contenir au moins 8 caractères';
        isPasswordValid = false;
    }
    if(!value.match(/[A-Z]/)) {
        errorMessage += '<br>- Contenir au moins une majuscule';
        isPasswordValid = false;
    }
    if(!value.match(/[0-9]/)) {
        errorMessage += '<br>- Contenir au moins un chiffre';
        isPasswordValid = false;
    }
    if(!value.match(/[a-z]/)) {
        errorMessage += '<br>- Contenir au moins une minuscule';
        isPasswordValid = false;
    }
    if(!value.match(/[^a-zA-Z0-9]/)) {
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

$('#password').on('input', validatePassword);
$('#form').on('submit', function(e) {
    if(!validatePassword()) {
        e.preventDefault();
    }
});