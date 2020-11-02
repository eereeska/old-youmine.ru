@extends('layouts.admin')
@section('content')
<div class="content">
    <input id="search-query" type="text" placeholder="Введите фразу для поиска и нажмите Enter" autocomplete="off" class="mb-40">
    <table id="search-table" class="striped">
        <thead>
            <tr>
                <th class="text-left">Пользователь</th>
                <th class="text-center">IP</th>
                <th class="text-right">Дата</th>
            </tr>
        </thead>
        <tbody id="search-result">
            @include('pages.admin.server.login_attempts.list', [
                'attempts' => $attempts
            ])
        </tbody>
    </table>
</div>
<script>
    $('#search-query').on('keyup', function(e) {
        if (e.key !== 'Enter') {
            return;
        }

        e.preventDefault();
        
        var input = $(this);

        $('#search-table').addClass('loading');

        axios.post('{{ route('admin-server-login-attempts') }}', {
            searchQuery: input.val().trim()
        }).then(function(response) {
            if (response.data.success) {
                $('#search-result').html(response.data.html);
            } else {
                alert(response.data.message);
            }

            $('#search-table').removeClass('loading');
        }).catch(function(error) {
            $('#search-table').removeClass('loading');

            if (error.response.status == 419) {
                alert('Ваш токен более недействителен. Перезагрузите страницу и попробуйте снова')
            }
        });
    });
</script>
@endsection