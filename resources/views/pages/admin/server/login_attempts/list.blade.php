@foreach ($attempts as $attempt)
<tr>
    <td class="text-left">
        <a href="https://vk.com/id{{ $attempt->user->vk_id }}" target="_blank" class="flex aic">
            <div class="avatar" style="background-image: url({{ $attempt->user->vk_avatar }})"></div>
            <span>{{ $attempt->user->vk_first_name }} {{ $attempt->user->vk_last_name }} ({{ $attempt->user->name }})</span>
        </a>
    </td>
    <td class="text-center">{{ $attempt->ip }}</td>
    <td class="text-right">{{ $attempt->created_at->format('H:i:s d.m.Y') }}</td>
</tr>
@endforeach