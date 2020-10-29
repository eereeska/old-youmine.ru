@foreach ($users as $user)
<tr>
    <td class="text-left">
        <a href="https://vk.com/{{ $user->vk_link }}" target="_blank" class="flex aic">
            <div class="avatar" style="background-image: url({{ $user->vk_avatar }})"></div>
            <span>{{ $user->vk_first_name }} {{ $user->vk_last_name }}</span>
        </a>
    </td>
    <td class="text-center">{{ $user->created_at->format('d.m.Y') }}</td>
    <td class="flex jcr gap-20 text-right">
        <div class="button green">Одобрить</div>
        <div class="button red">Удалить</div>
    </td>
</tr>
@endforeach