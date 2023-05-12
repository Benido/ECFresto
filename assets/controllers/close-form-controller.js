import { Controller } from '@hotwired/stimulus';

export default class extends Controller {

    closeForm(event) {
        event.target.closest('form').remove()
    }


}