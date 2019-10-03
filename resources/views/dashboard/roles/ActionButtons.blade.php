@canany(['role-edit', 'role-delete', 'role-list'])
    <div class="actions-td">
        <a href="{{ route('roles.show', $id) }}"><i class="fa fa-eye fa-2x"></i></a>
        @can('role-edit')
            <a href="{{ route('roles.edit', $id) }}" style="color: #1AB394"><i class="fa fa-edit fa-2x"></i></a>
        @endcan

        @can('role-delete')
            <form method="POST" action='{{ route('roles.destroy', $id) }}'  style='display: inline' id="deleteForm">
            {{ csrf_field() }}
            {{ method_field('DELETE') }}
            <div class="form-group">
                <a href="#" id="deleteButton" style="color: red"
                   onclick="return confirm('Are you sure you want to delete this item?'),
                   document.getElementById('deleteForm').submit(); ">
                    <i class="fa fa-trash fa-2x"></i></a>
            </div>
            </form>
        @endcan
    </div>
@endcanany
