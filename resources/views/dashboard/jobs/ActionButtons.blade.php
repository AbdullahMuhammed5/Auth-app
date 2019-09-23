@canany(['job-edit', 'job-delete', 'job-list'])
        <td>
            <a href="/jobs/{{$row->id}}" class="btn btn-info">View</a>
        @if($row->name != 'Writer' && $row->name != 'Reporter')
            @can('job-edit')
                <a href="/jobs/{{$row->id}}/edit" class="btn btn-primary">Edit</a>
            @endcan

            @can('job-delete')
                <form method="POST" action='jobs/{{$row->id}}'  style='display: inline'>
                {{ csrf_field() }}
                {{ method_field('DELETE') }}
                <div class="form-group">
                    <input type="submit" class="btn btn-danger" value="Delete"
                           onclick="return confirm('Are you sure you want to delete this item?');">
                </div>
                </form>
            @endcan
        @endif
        </td>
@endcanany
