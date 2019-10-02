<td>
    <div class="toggle-btn @if($row->is_active) active @endif">
        <input type="checkbox" @if($row->is_active) checked @endif class="cb-value" onclick="return confirm('Are You Sure?')" />
        <span class="round-btn"></span>
    </div>
</td>

<script>
    $('.cb-value').click(function() {
        let mainParent = $(this).parent('.toggle-btn');
        if($(mainParent).find('input.cb-value').is(':checked')) {
            $(mainParent).addClass('active');
        } else {
            $(mainParent).removeClass('active');
        }
        let csrf_token = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            type: 'PUT',
            url: "{{route('toggleVisitorStatus', $row)}}",
            headers: { 'X-CSRF-TOKEN': csrf_token },
            success:function(res){
                console.log(res)
            },
            error: function(){
                console.log(error)
            }
        });
    });
</script>
