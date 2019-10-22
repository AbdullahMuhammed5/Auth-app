<td>
    <div class="toggle-btn @if($row->published) active @endif">
        <input type="checkbox" @if($row->published) checked @endif class="cb-value" id="{{$row->type.$row->id}}"/>
        <span class="round-btn"></span>
    </div>
</td>


