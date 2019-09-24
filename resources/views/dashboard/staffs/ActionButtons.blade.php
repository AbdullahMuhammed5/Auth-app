@canany(['staff-edit', 'staff-delete', 'staff-list'])
    <td>
        <a href="/staff/{{$row->user_id}}" class="btn btn-info">View</a>
        @can('staff-edit')
            <a href="/staff/{{$row->user_id}}/edit" class="btn btn-primary">Edit</a>
        @endcan

        @can('staff-delete')
            <form method="POST" action='staff/{{$row->user_id}}'  style='display: inline'>
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
