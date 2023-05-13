import { Controller } from '@hotwired/stimulus';

export default class extends Controller {

    static values = {
        id: Number,
        menuid: Number
    }

    getForm() {
        const $formWrapper = $('#edit_form_wrapper_' + this.menuidValue + '_formula')
        $.ajax({
            url: '/administration/publier-menus/editer-formule/' + this.menuidValue + '/' + this.idValue,
            type: 'POST',
            success: function (data) {
                $formWrapper.html(data)
            }
        })
    }

    removeFormula() {
       const menuId = '#menu_' + this.menuidValue.toString()

        $.ajax({
            url: '/administration/publier-menus/supprimer-formule/' + this.idValue,
            type: 'POST',
            success: function () {
                $.ajax({
                    url: '/administration/publier-menus',
                    type: 'POST',
                    //On remplace la section Menus
                    complete: function(data){
                        $(menuId).replaceWith($(data.responseText).find(menuId))
                    }
                })
            }
        })
    }
}