@foreach($data as $event)
{{--@dd($event)--}}
    <ul>
        <li>{{ $event['main_title'] }}</li>
        <li>{{ $event['secondary_title'] }}</li>
        <li>{{ $event['location']}}</li>
        <li>{{ $event['start_date'] }}</li>
        <li>{{ $event['end_date'] }}</li>
        <li>{{ $event['content'] }}</li>
    </ul>

@endforeach
