import { Controller } from '@hotwired/stimulus';

//Masque/fait apparaître le formulaire d'édition des horaires
export default class extends Controller {
    static values = {
        weekday : String
    }

    revealForm() {
        const forms = document.getElementById('form')
        const addButton = document.getElementById('add')
        const formContainer = document.getElementById('formContainer')

        //Click the "Ajouter" button have a form already opened when it's revealed
        for (const form of  forms.querySelectorAll('li')) {
            form.remove()
        }
        formContainer.setAttribute("data-form-collection-weekday-value", this.weekdayValue)
        addButton.click()
        forms.removeAttribute('hidden')
    }
}

