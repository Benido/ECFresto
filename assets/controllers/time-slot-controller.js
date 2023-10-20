import { Controller } from '@hotwired/stimulus';

export default class extends Controller {

    async updateTimeSlots() {
        const $form = $('#reservation_form')
        const $day = $('#reservation_day')
        const $seats = $('#reservation_seats_number')

        $.ajax({
            url : $form.attr('action'),
            type: $form.attr('method'),
            data :
                {   //On simule le contenu du formulaire mais on ajoute que les valeur des champs 'day' et 'seats_number'
                    'day': $day.val(),
                    'seats': $seats.val()
                },
            complete: function(html) {
                //On remplace le champs 'time' avec celui de la réponse Ajax
                $('#reservation_time_slots').replaceWith(
                    $(html.responseText).find('#reservation_time_slots')
                )
            }
        })

    }

    revealClientInfoPart() {
        const $timeSlots = $('#reservation_time_slots')
        const seats = $('#reservation_seats_number').find(":selected").text();
        const day = new Date($('#reservation_day').val()).toLocaleDateString('fr-FR', {weekday: 'long',day: 'numeric', month: 'long', year: 'numeric'})
        const $selectedSlot = $timeSlots.find(":checked")
        const time = $timeSlots.find("label[for=" + $selectedSlot.attr("id") + "]").text()

        const reservationRecapText = seats + ' le ' + day + ' à ' + time
        $('#reservation_date_recap_text').text(reservationRecapText)

        $('#reservation_client_info').show()
        $('#reservation_time_slots,#reservation_seats_day_selection').hide()
        $('#reservation_date_recap').show()
    }

    revertHiding() {
        $('#reservation_client_info').hide()
        $('#reservation_time_slots,#reservation_seats_day_selection').show()
        $('#reservation_date_recap').hide()
    }

}