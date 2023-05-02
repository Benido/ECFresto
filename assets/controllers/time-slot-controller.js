import { Controller } from '@hotwired/stimulus';

export default class extends Controller {

    async updateTimeSlots() {
        const form = $('#reservation_form')
        const day = $('#reservation_day')

        $.ajax({
            url : form.attr('action'),
            type: form.attr('method'),
            data :
                {   //On simule le contenu du formulaire mais on ajoute que la valeur du champs 'day'
                    'reservation[day]': day.val(),
                },
            complete: function(html) {
                //On remplace le champs 'time' avec celui de la réponse Ajax
                $('#reservation_time').replaceWith(
                    $(html.responseText).find('#reservation_time')
                )
            }
        })

    }

}