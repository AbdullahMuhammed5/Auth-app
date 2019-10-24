{{--{{ dd($authorized_users) }}--}}
<td style="width: 350px">
    <ul>
        @foreach ($authorized_users as $user )
{{--            {{ dd($user['user']['first_name']) }}--}}
            <li class="badge badge-success">{{ $user['user']['first_name'].' '.$user['user']['last_name'] }}</li>
        @endforeach
    </ul>
</td>
