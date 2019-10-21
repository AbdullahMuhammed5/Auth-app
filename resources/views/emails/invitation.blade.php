@component('mail::message')

We are glad to inform you that you are invited to our event, which will hold on "location", starting from 'start date' to 'end date'.


@component('mail::button', ['url' => ''])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
