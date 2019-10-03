@canany(['visitor-edit', 'visitor-delete'])

    <div class="actions-td">

        <a href="{{ route($route.'.show', $id) }}"><i class="fa fa-eye fa-2x"></i></a>

        @can('staff-edit')
            <a href="{{ route($route.'.edit', $id) }}" style="color: #1ab394"><i class="fa fa-edit fa-2x"></i></a>
        @endcan

        @can('staff-delete')
            <form method="POST" action='{{ route($route.'.destroy', $id) }}'  style='display: inline' id="deleteForm">
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
