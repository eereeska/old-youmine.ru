// window._ = require('lodash');

$('#upload-skin').on('click', function(e) {
    e.preventDefault();

    $('#upload-skin-input').trigger('click');
});

$('#upload-skin-input').on('change', function(e) {
    var avatar = $('#upload-skin');

    if (avatar.hasClass('loading')) {
        return;
    }

    var files = $('#upload-skin-input')[0].files;

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

$('#deposit').on('click', function(e) {
    e.preventDefault();

    var sum = prompt('Введите сумму в рублях:',  10);

    if (sum != null) {
        if (parseInt(sum) < 10) {
            return alert('Минимальная сумма пополнения: 10 рублей');
        }

        window.location.href = $(this).data('redirect') + '?sum=' + parseInt(sum);
    }
});
// $(document).on('click', '[data-action="toggle"]', function(e) {
//     e.preventDefault();

//     var clickedElement = $(this);

//     if (clickedElement.data('toggle-type') == 'request') {
//         axios.post('/front/toggle', {
//             target: clickedElement.data('toggle-target')
//         }).then(function(response) {
//             if (response.data.success) {
//                 clickedElement.toggleClass('active');
//             } else {
//                 alert(response.data.message);
//             }
//         }).catch(function(error) {
//             if (error.response.status == 419) {
//                 alert('Ваш токен более недействителен. Перезагрузите страницу и попробуйте снова')
//             }
//         });
//     }
// });

// $(document).on('click', '[data-action="request"]', function(e) {
//     e.preventDefault();

//     var clickedElement = $(this);

//     if (clickedElement.data('request-callback') == 'alert') {
//         axios.get(clickedElement.attr('href')).then(function(response) {
//             alert(response.data.message);
//         }).catch(function(error) {
//             if (error.response.status == 419) {
//                 alert('Ваш токен более недействителен. Перезагрузите страницу и попробуйте снова')
//             } else {
//                 alert('Произошла ошибка при обработке запроса')
//             }
//         });
//     }
// });

// $(document).on('click', '[data-action="submit-form"]', function(e) {
//     e.preventDefault();
    
//     $('#' + $(this).data('form')).trigger('submit');
// });