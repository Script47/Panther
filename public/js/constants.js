var App = {
    AJAX_BASE: $('head meta[name=ajax-base]').attr('content')
};

$.ajaxSetup({
    beforeSend: function (jq_xhr, settings) {
        $('body').append(
            '<div id="ajax-indicator" class="center-screen fas fa-spinner fa-pulse fa-3x"></div>'
        );

        if (
            settings.type === 'POST' &&
            localStorage.getItem('ajax-token') !== null
        ) {
            if (typeof settings.data === 'undefined') {
                settings.data = 'ajax-token=' + localStorage.getItem('ajax-token');
            } else {
                settings.data += '&ajax-token=' + localStorage.getItem('ajax-token');
            }
        }
    },

    complete: function () {
        $('#ajax-indicator').remove();
    }
});

if (localStorage.getItem('ajax-token') === null) {
    $.get(
        App.AJAX_BASE + '/ajax-token/get.php',
        {
            'ajax-token': 'requesting-ajax-token'
        },
        function (response) {
            response = JSON.parse(response);

            if (response.hasOwnProperty('data'))
                if (response['data'].hasOwnProperty('ajax-token'))
                    localStorage.setItem('ajax-token', response.data['ajax-token']);
        }
    );
}