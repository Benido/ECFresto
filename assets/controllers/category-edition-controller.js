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
}