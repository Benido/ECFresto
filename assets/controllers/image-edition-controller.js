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
                $formWrapper.prev('img').toggleClass('bottom-border-radius')
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
                    //On remplace le contenu de la section Images
                    complete: function(data){
                        $('#images').replaceWith($(data.responseText).find('#images'))
                    }
                })
            }
        })
    }

    closeForm(event) {
        const html = '<h3>Ajouter une image</h3><div class="text-center" data-controller="image-edition" data-action="click->image-edition#getForm"> <i id="plus_icon" class="bi bi-plus-circle fs-1"></i>'

        event.target.closest('form').remove()
        if (this.idValue !== 0) {
            $('#image_form_' + this.idValue).prev('img').toggleClass('bottom-border-radius')
        } else {
           $('#image_form_0').html(html)
        }
    }
}