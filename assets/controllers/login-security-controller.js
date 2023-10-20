import { Controller } from '@hotwired/stimulus';

export default class extends Controller {

    static targets = ["emailInput", "emailError", "passwordInput", "passwordError"]

    checkIfEmail() {
        const emailPattern = new RegExp(/^[-\w.]+@([-\w]+\.)+[-\w]{2,4}$/gm)
        if(!this.emailInputTarget.value.match(emailPattern)) {
            this.emailErrorTarget.textContent = "Entrez une adresse email valide"
        } else {
            this.emailErrorTarget.textContent = ""
        }
    }

    checkPassword() {
        const passwordPattern = new RegExp(/^.{4,}$/gm)
        if(!this.passwordInputTarget.value.match(passwordPattern)) {
            this.passwordErrorTarget.textContent = "Veuillez entrer un mot de passe valide"
        } else {
            this.passwordErrorTarget.textContent = ""
        }
    }
}