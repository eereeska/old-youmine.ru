window.$ = require('jquery');
window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios.defaults.headers.common['X-CSRF-TOKEN'] = $('meta[name="csrf-token"]').attr('content');

$(document).on('click', '[data-action="toggle"]', function(e) {
    e.preventDefault();

    var clickedElement = $(this);

    if (clickedElement.data('toggle-type') == 'request') {
        axios.post('/front/toggle', {
            target: clickedElement.data('toggle-target')
        }).then(function(response) {
            if (response.data.success) {
                clickedElement.toggleClass('active');
            } else {
                alert(response.data.message);
            }
        }).catch(function(error) {
            if (error.response.status == 419) {
                alert('Ваш токен более недействителен. Перезагрузите страницу и попробуйте снова')
            }
        });
    }
});

$(document).on('click', '[data-action="submit-form"]', function(e) {
    e.preventDefault();
    
    $('#' + $(this).data('form')).trigger('submit');
});