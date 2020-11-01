window._ = require('lodash');
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

$(document).on('click', '[data-action="request"]', function(e) {
    e.preventDefault();

    var clickedElement = $(this);

    if (clickedElement.data('request-callback') == 'alert') {
        axios.get(clickedElement.attr('href')).then(function(response) {
            alert(response.data.message);
        }).catch(function(error) {
            if (error.response.status == 419) {
                alert('Ваш токен более недействителен. Перезагрузите страницу и попробуйте снова')
            } else {
                alert('Произошла ошибка при обработке запроса')
            }
        });
    }
});

$(document).on('click', '[data-action="submit-form"]', function(e) {
    e.preventDefault();
    
    $('#' + $(this).data('form')).trigger('submit');
});

$('#skin-upload').on('click', function(e) {
    e.preventDefault();

    $('#skin-upload-input').trigger('click');
});

$('#skin-upload-input').on('change', function(e) {
    var avatar = $('#skin-upload');

    if (avatar.hasClass('loading')) {
        return;
    }

    var files = $('#skin-upload-input')[0].files;

    if (files.length < 1) {
        return;
    }

    var form = new FormData();

    form.append('skin', files[0]);

    avatar.addClass('loading');

    axios.post('/front/skin', form).then(function(response) {
        if (response.data.success) {
            avatar.css('background-image', 'url(' + response.data.skin.avatar + ')');
        } else {
            alert(response.data.message);
        }

        avatar.removeClass('loading');
    }).catch(function(error) {
        avatar.removeClass('loading');

        if (error.response.status == 419) {
            alert('Ваш токен более недействителен. Перезагрузите страницу и попробуйте снова')
        } else {
            alert('Произошла ошибка при обработке запроса')
        }
    });
});

$('#deposit-input').on('keyup', _.debounce(function(e) {
    var sum = parseInt($(this).val());

    if (!sum) {
        return;
    }

    if (e.key !== 'Enter') {
        axios.get('/front/deposit/convert/rub/coins?sum=' + sum).then(function(response) {
            if (response.data.success) {
                $('#deposit-coins-sum').text(response.data.message);
            } else {
                $('#deposit-coins-sum').html('<span class="light-red">' + response.data.message + '</span>')
            }
        }).catch(function() {
            alert('Произошла ошибка при обработке запроса')
        });

        return;
    }

    if (sum >= 10) {
        return window.location.href = $(this).data('redirect') + '?sum=' + sum;
    }
}, 300));