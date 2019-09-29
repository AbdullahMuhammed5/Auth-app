@canany(['city-edit', 'city-delete'])
    <td>
        @can('city-edit')
            <a href="{{ route('cities.edit', $id) }}" class="btn btn-primary">Edit</a>
        @endcan

        @can('city-delete')
            <form method="POST" action='{{ route('cities.destroy', $id) }}'  style='display: inline'>
            {{ csrf_field() }}
            {{ method_field('DELETE') }}
            <div class="form-group">
                <input type="submit" class="btn btn-danger delete-user" value="Delete"
                       onclick="return confirm('Are you sure you want to delete this item?');">
            </div>
            </form>
        @endcan
    </td>
@endcanany
