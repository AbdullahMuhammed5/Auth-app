@canany(['visitor-edit', 'visitor-delete', 'visitor-list'])
    <td>
        <a href="{{ route('visitors.show', $id) }}" class="btn btn-info">View</a>
        @can('visitor-edit')
            <a href="{{ route('visitors.edit', $id) }}" class="btn btn-primary">Edit</a>
        @endcan

        @can('visitor-delete')
            <form method="POST" action='{{ route('visitors.destroy', $id) }}'  style='display: inline'>
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
