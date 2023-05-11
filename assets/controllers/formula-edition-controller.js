import { Controller } from '@hotwired/stimulus';

export default class extends Controller {

    static values = {
        id: Number,
        menuid: Number
    }

    getForm() {
        const $formWrapper = $('#edit_form_wrapper_' + this.menuidValue + '_formula_' + this.idValue)
        $.ajax({
            url: '/administration/publier-menus/editer-formule/' + this.menuidValue + '/' + this.idValue,
            type: 'POST',
            success: function (data) {
                $formWrapper.html(data)
            }
        })
    }
}