import { Controller } from '@hotwired/stimulus';

export default class extends Controller {

    connect() {
        const dimmedScreen = $('#dimmed_screen')
        const adminSidebar = $('#admin_sidebar');
        const chevron = $('#sidebar-button > div > i')

        adminSidebar.on('hide.bs.collapse', function() {
            dimmedScreen.hide()
            chevron.removeClass('bi-chevron-compact-left').addClass('bi-chevron-compact-right')
        })
        adminSidebar.on('show.bs.collapse', function() {
            dimmedScreen.show()
            chevron.removeClass('bi-chevron-compact-right').addClass('bi-chevron-compact-left')
        })
    }
}

