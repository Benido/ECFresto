import { Controller } from '@hotwired/stimulus';

export default class extends Controller {

    static targets = [ "listItem"]

    async cancelReservation(event) {
        const reservationId = event.target.getAttribute('data-reservation-id')

        $.ajax({
            url: '/client-preferences/cancel-reservation',
            type: 'POST',
            data: {'reservationId': reservationId},
            success: function(data, status) {
                if (status === 'nocontent') {
                    event.target.closest('li').remove()
                }
            },
            error: function() {
                event.target.closest('.cancellation-error').text('Il y a eu un problème avec le serveur. Pouvez-vous réessayer ?')
            }
        })
    }

}