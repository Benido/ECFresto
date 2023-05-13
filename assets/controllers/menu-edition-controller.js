import { Controller } from '@hotwired/stimulus';

export default class extends Controller {

    static values = { id: Number }

    getForm() {
        const $formWrapper = $('#edit_menu_form_wrapper_' + this.idValue)
        $.ajax({
            url: '/administration/publier-menus/editer-menu/' + this.idValue,
            type: 'POST',
            success: function (data) {
                $formWrapper.html(data)
            }
        })
    }

    removeMenu() {
        $.ajax({
            url: '/administration/publier-menus/supprimer-menu/' + this.idValue,
            type: 'POST',
            success: function () {
                $.ajax({
                    url: '/administration/publier-menus',
                    type: 'POST',
                    //On remplace le contenu de la section "Menus"
                    complete: function(data){
                        $('#menus').replaceWith($(data.responseText).find('#menus'))
                    }
                })
            }
        })
    }
}