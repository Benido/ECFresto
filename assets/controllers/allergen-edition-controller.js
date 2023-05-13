import { Controller } from '@hotwired/stimulus';

export default class extends Controller {

    static values = { id: Number }

    getForm() {
        const $formWrapper = $('#edit_allergen_form_wrapper')

        $.ajax({
            url: '/administration/publier-menus/editer-allergene-' + this.idValue,
            type: 'POST',
            success: function (data) {
                $formWrapper.html(data)
            }
        })
    }

    removeAllergen() {
        $.ajax({
            url: '/administration/publier-menus/supprimer-allergene/' + this.idValue,
            type: 'POST',
            success: function () {
                $.ajax({
                    url: '/administration/publier-menus',
                    type: 'POST',
                    //On remplace le contenu de la section "Allergènes
                    complete: function(data){
                        $('#allergenes').replaceWith($(data.responseText).find('#allergenes'))
                    }
                })
            }
        })
    }
}