@canany(['role-edit', 'role-delete', 'role-list'])
    <td>
        <a href="{{ route('roles.show', $id) }}" class="btn btn-info">View</a>
        @can('role-edit')
            <a href="{{ route('roles.edit', $id) }}" class="btn btn-primary">Edit</a>
        @endcan

        @can('role-delete')
            <form method="POST" action='{{ route('roles.destroy', $id) }}'  style='display: inline'>
            {{ csrf_field() }}
            {{ method_field('DELETE') }}
            <div class="form-group">
                <input type="submit" class="btn btn-danger" value="Delete"
                       onclick="return confirm('Are you sure you want to delete this item?');">
            </div>
            </form>
        @endcan
    </td>
@endcanany
