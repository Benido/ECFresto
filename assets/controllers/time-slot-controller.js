import { Controller } from '@hotwired/stimulus';

export default class extends Controller {

    async updateTimeSlots() {
        const form = $('#reservation_form')
        const day = $('#reservation_day')
        const seats = $('#reservation_seats_number')

        $.ajax({
            url : form.attr('action'),
            type: form.attr('method'),
            data :
                {   //On simule le contenu du formulaire mais on ajoute que les valeur des champs 'day' et 'seats_number'
                    //'reservation[day]': day.val(),
                    //'reservation[seats_number]': seats.val()
                    'day': day.val(),
                    'seats': seats.val()
                },
            complete: function(html) {
                //On remplace le champs 'time' avec celui de la réponse Ajax
                $('#reservation_date').replaceWith(
                    $(html.responseText).find('#reservation_date')
                )
            }
        })

    }

}