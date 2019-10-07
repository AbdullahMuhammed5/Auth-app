<td>
    <div class="toggle-btn @if($row->published) active @endif">
        <input type="checkbox" @if($row->published) checked @endif class="cb-value" id="{{$row->type.$row->id}}"/>
        <span class="round-btn"></span>
    </div>
</td>

<script>
    $('#{{$row->type.$row->id}}').click(function() {
        let mainParent = $(this).parent('.toggle-btn');
        let csrf_token = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            type: 'PUT',
            url: "{{route('togglePublishNews', $row)}}",
            headers: { 'X-CSRF-TOKEN': csrf_token },
            success:(response) => {
                if($(mainParent).find('input.cb-value').is(':checked')) {
                    $(mainParent).addClass('active');
                } else {
                    $(mainParent).removeClass('active');
                }
            },
            error: (error) => console.log(error)
        });
    });
</script>
