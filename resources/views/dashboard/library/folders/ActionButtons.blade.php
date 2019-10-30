@canany(["folder-create"])
    <div class="actions-td">
        <a href="{{ route("folders.edit", $id) }} " style="color: #1AB394"><i class="fa fa-edit fa-2x"></i></a>

        <form method="POST" action='{{ route("folders.destroy", $id) }}'  style='display: inline' id="deleteForm">
            {{ csrf_field() }}
            {{ method_field('DELETE') }}
            <div class="form-group">
                <a href="#" id="deleteButton" style="color: red"
                   onclick="return confirm('Are you sure you want to delete this item?'),
               document.getElementById('deleteForm').submit(); ">
                    <i class="fa fa-trash fa-2x"></i></a>
            </div>
        </form>
    </div>
@endcanany
