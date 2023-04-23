import { Controller } from '@hotwired/stimulus';

//Ajoute les formulaires permettant d'éditer les horaires d'une journée précise
export default class extends Controller {
    static targets = ["collectionContainer"]

    static values = {
        index    : Number,
        prototype: String,
    }

    //Ajoute un nouveau formulaire lors du clic sur le bouton "Ajouter"
    addCollectionElement(event)
    {
        const item = document.createElement('li');
        item.innerHTML = this.prototypeValue.replace(/__name__/g, this.indexValue);
        this.removeCollectionElement(item)
        this.setClosed()
        this.collectionContainerTarget.appendChild(item);
        this.indexValue++;
    }

    //Ajoute le bouton permettant de supprimer le formulaire
    removeCollectionElement(item) {
        const removeButton = document.createElement('button')
        removeButton.innerHTML = "Enlever"
        item.appendChild(removeButton)
        removeButton.addEventListener('click', () => item.remove())
    }

    setClosed() {
        /*
        const checkIsClosed = document.createElement('div')
        const checkIsClosedLabel = document.createElement('label')
        checkIsClosedLabel.innerText = "fermé toute la journée"
        const checkIsClosedInput = document.createElement('input')
        checkIsClosedInput.setAttribute('type', 'checkbox')
        checkIsClosed.appendChild(checkIsClosedLabel)
        checkIsClosed.appendChild(checkIsClosedInput)
        */
        const checkIsClosedInput = document.getElementById('isClosed')
        checkIsClosedInput.addEventListener('change', this.setInputValuesToNull )
    }

    setInputValuesToNull() {
        const checkbox = document.getElementById('isClosed')
        const selectInputs = document.querySelectorAll('div.select > select')

        alert('youhou')
        if(checkbox.checked) {
            for (const input of selectInputs) {
                input.value = null
                input.setAttribute('disabled', 'true')
            }
        } else {
            for (const input of selectInputs) {
                input.setAttribute('disabled', 'false')
            }
        }
    }

}