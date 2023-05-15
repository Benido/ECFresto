import { Controller } from '@hotwired/stimulus';

export default class extends Controller {

    static values = { id: Number }

    getForm() {
        const $formWrapper = $('#image_form_' + this.idValue)

        $.ajax({
            url: '/administration/modifier-galerie/editer/' + this.idValue,
            type: 'POST',
            success: function (data) {
                $formWrapper.html(data)
            }
        })
    }

    removeImage() {
        $.ajax({
            url: '/administration/modifier-galerie/supprimer/' + this.idValue,
            type: 'POST',
            success: function () {
                $.ajax({
                    url: '/administration/modifier-galerie',
                    type: 'POST',
                    //On remplace le contenu de la section "Allergènes
                    complete: function(data){
                        $('#images').replaceWith($(data.responseText).find('#images'))
                    }
                })
            }
        })
    }
}