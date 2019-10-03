<td>
    <div class="toggle-btn @if($row->is_active) active @endif">
        <input type="checkbox" @if($row->is_active) checked @endif class="cb-value" id="{{$row->user->first_name.$row->id}}"/>
        <span class="round-btn"></span>
    </div>
</td>

<script>
    $('#{{$row->user->first_name.$row->id}}').click(function() {
        let mainParent = $(this).parent('.toggle-btn');
        let csrf_token = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            type: 'PUT',
            url: "{{route('toggleStaffStatus', $row)}}",
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
