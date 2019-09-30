<td style="width: 350px">
    <ul>
        @foreach ($permissions as $permission )
            <li class="badge badge-success">{{ $permission['name'] }}</li>
        @endforeach
    </ul>
</td>
