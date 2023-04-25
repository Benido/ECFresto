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
        if( this.collectionContainerTarget.childElementCount < 4)
        {
            const item = document.createElement('li');
            item.classList.add('list-group-item', 'p-1', 'my-1', 'hideable')
            item.innerHTML = this.prototypeValue.replace(/__name__/g, this.indexValue);
            this.addRemoveButton(item)
            this.setClosed()
            this.collectionContainerTarget.appendChild(item);
            if (this.collectionContainerTarget.childElementCount === 1) {
                const weekdayLabel = document.getElementById('weekdayDisplay')
                weekdayLabel.innerText = this.weekdayValue
            }
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

    //Vérifie si la checkbox est cochée et le cas échéant, passe la valeur des inputs à null et leur attribut disabled à true
    setClosed() {
        const checkbox = document.getElementById('isClosed')
        checkbox.addEventListener('change', this.isClosedHandler)
    }

    //handler de isClosed()
    isClosedHandler() {
        const checkbox = document.getElementById('isClosed')
        const addButton = document.getElementById('add')
        const forms = document.getElementsByClassName('hideable')
        const selectInputs = document.querySelectorAll('div.select > select')

        if (checkbox.checked) {
            addButton.setAttribute('hidden', '')
            for (const child of forms) {
                //garde un formulaire pour pouvoir transmettre les valeurs null, supprime les autres
                child.setAttribute('hidden', '')
                do {
                    child.nextElementSibling.remove()
                } while (child.nextElementSibling)
            }
            for (const input of selectInputs) {
                //mets la valeur des select à null
                input.value = null
            }
        } else {
            addButton.removeAttribute('hidden')
            for (const child of forms) {
                child.removeAttribute('hidden')
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