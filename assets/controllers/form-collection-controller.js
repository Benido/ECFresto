import { Controller } from '@hotwired/stimulus';

//Ajoute les formulaires permettant d'éditer les horaires d'une journée précise
export default class extends Controller {
    static targets = ["collectionContainer"]

    static values = {
        index    : Number,
        prototype: String,
        weekday  : String,
    }


    //Ajoute un nouveau formulaire lors du clic sur le bouton "Ajouter"
    addCollectionElement()
    {
        //On limite à 3 le nombre de formulaires
        console.log(this.collectionContainerTarget.childElementCount)
        if( this.collectionContainerTarget.childElementCount < 3)
        {
            const item = document.createElement('li');
            item.innerHTML = this.prototypeValue.replace(/__name__/g, this.indexValue);
            this.addRemoveButton(item)
            this.setClosed()
            this.collectionContainerTarget.appendChild(item);
            this.setWeekdayValue()
            this.indexValue++;
        }
    }

    //Ajoute le bouton et le listener permettant de supprimer le formulaire
    addRemoveButton(item) {
        const removeButton = document.createElement('button')
        removeButton.innerHTML = "Enlever"
        item.appendChild(removeButton)
        removeButton.addEventListener('click', () => item.remove())
    }

    //Ecoute le statut de la checkbox "fermé pour la journée"
    setClosed() {
        const checkIsClosedInput = document.getElementById('isClosed')
        checkIsClosedInput.addEventListener('change', this.setInputValuesToNull )
    }

    //Vérifie si la checkbox est cochée et le cas échéant, passe la valeur des inputs à null et leur attribut disabled à true
    setInputValuesToNull() {
        const checkbox = document.getElementById('isClosed')
        const selectInputs = document.querySelectorAll('div.select > select')
        if(checkbox.checked) {
            for (const input of selectInputs) {
                //mets les valeurs à null et active l'attribut "disabled"
                input.value = null
                input.setAttribute('disabled', 'true')
            }
        } else {
            for (const input of selectInputs) {
                input.removeAttribute('disabled')
            }
        }
    }

    //Récupère la valeur du jour à éditer et l'applique au sélecteur
    setWeekdayValue() {
        const weekdaySelector = this.collectionContainerTarget.getElementsByClassName('weekday')
        for (const selector of weekdaySelector) {
            selector.value = this.weekdayValue
        }
    }

}