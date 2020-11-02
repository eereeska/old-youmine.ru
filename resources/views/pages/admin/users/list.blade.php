@foreach ($users as $user)
<tr>
    <td class="text-left"><a href="{{ route('admin-users-edit', ['id' => $user->id]) }}" target="_blank">#{{ $user->id }}</a></td>
    <td class="text-left">
        <a href="https://vk.com/id{{ $user->vk_id }}" target="_blank" class="flex aic">
            <div class="avatar" style="background-image: url({{ $user->vk_avatar }})"></div>
            <span>{{ $user->vk_first_name }} {{ $user->vk_last_name }}</span>
        </a>
    </td>
    <td class="text-left">{{ $user->name }}</td>
    <td class="text-left">{{ $user->balance }} {{ trans_choice('коин|коина|коинов', $user->balance, [], 'ru') }}</td>
    <td class="text-left" title="{{ $user->ip }}">{{ $user->country ?? 'Неизвестно' }}</td>
    <td class="text-right" title="{{ $user->created_at->format('d.m.Y H:i:s') }}">{{ $user->created_at->format('d.m.Y') }}</td>
</tr>
@endforeach