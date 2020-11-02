@extends('layouts.admin')
@section('content')
<div class="content admin-stats">
    <a href="{{ route('admin-users') }}"><h3>Новых пользователей</h3></a>
    <canvas id="users-registered" class="mb-40"></canvas>
    <script>
        new Chart(document.getElementById('users-registered'), {
            type: 'line',
            data: {
                labels: [
                    @foreach ($users['registered'] as $key => $value)
                    '{{$key}}',
                    @endforeach
                ],
                datasets: [
                    {
                        data: [@foreach (array_keys($users['registered']->toArray()) as $key){{ $users['registered'][$key]->count() }}, @endforeach],
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                legend: {
                    display: false
                },
                responsive: true,
                spanGaps: false,
                elements: {
                    line: {
                        tension: 0.000001
                    }
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            precision: 0
                        }
                    }]
                }
            }
        });
    </script>
    <a href="{{ route('admin-server-login-attempts') }}"><h3>Попыток войти на сервер</h3></a>
    <canvas id="server-login-attempts"></canvas>
    <script>
        new Chart(document.getElementById('server-login-attempts'), {
            type: 'line',
            data: {
                labels: [
                    @foreach ($server['login_attempts'] as $key => $value)
                    '{{$key}}',
                    @endforeach
                ],
                datasets: [
                    {
                        label: 'Авторизованные',
                        data: [@foreach (array_keys($server['login_attempts']->toArray()) as $key){{ $server['login_attempts'][$key]->where('user_id', '<>', null)->count() }}, @endforeach],
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Неавторизованные',
                        data: [@foreach (array_keys($server['login_attempts']->toArray()) as $key){{ $server['login_attempts'][$key]->where('user_id', null)->count() }}, @endforeach],
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                responsive: true,
                spanGaps: false,
                elements: {
                    line: {
                        tension: 0.000001
                    }
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            precision: 0
                        }
                    }]
                }
            }
        });
    </script>
</div>
@endsection