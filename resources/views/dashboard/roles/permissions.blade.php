<ul>
    @foreach ($permissions as $permission )
        <li class="badge badge-success">{{ $permission['name'] }}</li>
    @endforeach
</ul>
