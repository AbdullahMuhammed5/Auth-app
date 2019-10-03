@canany(['job-edit', 'job-delete', 'job-list'])
    <div class="actions-td">
        <a href="{{ route('jobs.show', $id) }}"><i class="fa fa-eye fa-2x"></i></a>
        @if($name != 'Writer' && $name != 'Reporter')
            @can('job-edit')
                <a href="{{ route('jobs.edit', $id) }}"><i class="fa fa-edit fa-2x"></i></a>
            @endcan

            @can('job-delete')
                <form method="POST" action='{{ route('jobs.destroy', $id) }}'  style='display: inline' id="deleteForm">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}
                <div class="form-group">
                    <a href="#" id="deleteButton"
                       onclick="return confirm('Are you sure you want to delete this item?'),
                       document.getElementById('deleteForm').submit(); ">
                        <i class="fa fa-trash fa-2x"></i></a>
                </div>
                </form>
            @endcan
        @endif
    </div>
@endcanany
