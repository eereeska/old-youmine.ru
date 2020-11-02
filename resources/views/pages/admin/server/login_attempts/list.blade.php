@foreach ($attempts as $attempt)
<tr>
    <td class="text-left">
        @if (is_null($attempt->user_id))
        Незарегистрированный
        @else
        <a href="https://vk.com/id{{ $attempt->user->vk_id }}" target="_blank" class="flex aic">
            <div class="avatar" style="background-image: url({{ $attempt->user->vk_avatar }})"></div>
            <span>{{ $attempt->user->vk_first_name }} {{ $attempt->user->vk_last_name }}</span>
        </a>
        @endif
    </td>
    @if (is_null($attempt->user_id))
    <td class="text-center">{{ $attempt->name }}</td>
    @else
    <td class="text-center"><a href="{{ route('admin-users-edit', ['id' => $attempt->user->id]) }}" target="_blank">{{ $attempt->name }}</a></td>
    @endif
    <td class="text-center">{{ $attempt->ip }}</td>
    <td class="text-right">{{ $attempt->created_at->format('H:i:s d.m.Y') }}</td>
</tr>
@endforeach