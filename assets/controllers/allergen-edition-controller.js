import { Controller } from '@hotwired/stimulus';

export default class extends Controller {

    static values = { id: Number }

    getForm() {
        const $formWrapper = $('#edit_allergen_form_wrapper_' + this.idValue)
        $.ajax({
            url: '/administration/publier-menus/editer-allergene-' + this.idValue,
            type: 'POST',
            success: function (data) {
                $formWrapper.html(data)
            }
        })
    }
}