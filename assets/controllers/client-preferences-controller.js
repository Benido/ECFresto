import { Controller } from '@hotwired/stimulus';

export default class extends Controller {

    passwordValidation() {
        const $password = $('#client_preferences_newPassword')
        const $error = $('#password_errors')

        $error.text('')
        if ($password.val().length <= 6) {
            $error.addClass('text-danger').prepend('&#10060; 6 caractères minimum')
        } else {
            $error.removeClass('text-danger').addClass('text-success').prepend('&#10004; 6 caractères minimum')
        }
    }


    passwordCheck() {
        const $passwordConfirmation = $('#client_preferences_newPasswordConfirmation')
        const $password = $('#client_preferences_newPassword')
        const $error = $('#password_confirmation_errors')

        $error.text('')
        if ($password.val() !== '' && $passwordConfirmation.val() !== $password.val()) {
            $error.addClass('text-danger').prepend('&#10060; Les mots de passe doivent être identiques')
        } else {
            $error.removeClass('text-danger').addClass('text-success').prepend('&#10004; Les mots de passe sont identiques')
        }
    }

}