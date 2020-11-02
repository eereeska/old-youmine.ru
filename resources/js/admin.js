// $('#search-query').on('keyup', function(e) {
//     if (e.key !== 13 && e.key !== 'Enter') {
//         return;
//     }

//     e.preventDefault();
    
//     var input = $(this);

//     $('#search-table').addClass('loading');

//     axios.post('/admin/users/unconfirmed/search', {
//         query: input.val().trim()
//     }).then(function(response) {
//         if (response.data.success) {
//             $('#search-result').html(response.data.users);
//         } else {
//             alert(response.data.message);
//         }

//         $('#search-table').removeClass('loading');
//     }).catch(function(error) {
//         $('#search-table').removeClass('loading');

//         if (error.response.status == 419) {
//             alert('Ваш токен более недействителен. Перезагрузите страницу и попробуйте снова')
//         }
//     });
// });