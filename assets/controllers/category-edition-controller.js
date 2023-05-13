import { Controller } from '@hotwired/stimulus';

export default class extends Controller {

    static values = { id: Number }

    getForm() {
        const $formWrapper = $('#edit_category_form_wrapper_' + this.idValue)
        $.ajax({
            url: '/administration/publier-menus/editer-categorie-' + this.idValue,
            type: 'POST',
            success: function (data) {
                $formWrapper.html(data)
            }
        })
    }

    removeCategory() {
        $.ajax({
            url: '/administration/publier-menus/supprimer-categorie/' + this.idValue,
            type: 'POST',
            success: function () {
                $.ajax({
                    url: '/administration/publier-menus',
                    type: 'POST',
                    //On remplace le contenu de la section "Menus"
                    complete: function(data){
                        $('#plats').replaceWith($(data.responseText).find('#plats'))
                    }
                })
            }
        })
    }
}