@foreach($users as $user)
    <tr>
        <td>
            <a href="{{ route('bookkeeper.users.edit', $user->getKey()) }}">{{ $user->full_name }}</a>
        </td>
        <td class="is-hidden-mobile">
            <a href="mailto:{{ $user->email }}">
                {{ $user->email }}
            </a>
        </td>
        <td class="is-hidden-mobile">
            {{ $user->created_at->formatLocalized('%b %e, %Y') }}
        </td>
        {!! resource_options_menu($resourceName, $user->getKey()) !!}
    </tr>
@endforeach
