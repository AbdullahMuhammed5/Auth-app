@canany(['city-edit', 'city-delete'])
    <td>
        @can('city-edit')
            <a href="/cities/{{$row->id}}/edit" class="btn btn-primary">edit</a>
        @endcan

        @can('city-delete')
            <form method="POST" action='cities/{{$row->id}}'  style='display: inline'>
            {{ csrf_field() }}
            {{ method_field('DELETE') }}
            <div class="form-group">
                <input type="submit" class="btn btn-danger delete-user" value="Delete">
            </div>
            </form>
        @endcan
    </td>
@endcanany
