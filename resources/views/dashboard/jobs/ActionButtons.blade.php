@canany(["job-edit", "job-delete", "job-list"])
    <div class="actions-td">
        <a href="{{ route("jobs.show", $id) }}"><i class="fa fa-eye fa-2x"></i></a>
        @if($name != 'Writer' && $name != 'Reporter')
            @can("job-edit")
                <a href="{{ route("jobs.edit", $id) }} " style="color: #1AB394"><i class="fa fa-edit fa-2x"></i></a>
            @endcan

            @can("$modelName-delete")
                <form method="POST" action='{{ route("jobs.destroy", $id) }}'  style='display: inline' id="{{'job'.$id}}">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <div class="form-group">
                        <a href="#" id="deleteButton" style="color: red"
                           onclick="return confirm('Are you sure you want to delete this item?'),
                           document.getElementById('{{"job".$id}}').submit(); ">
                            <i class="fa fa-trash fa-2x"></i></a>
                    </div>
                </form>
            @endcan
        @endif
    </div>
@endcanany
