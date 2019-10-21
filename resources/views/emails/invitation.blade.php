@component('mail::message')

    Hello, {{ $visitor->user->first_name.' '.$visitor->user->first_name }},
    Hope this email finds you well.

    We are glad to inform you that you are invited to our event, which will hold on {{ $event->location }}, starting from {{ $event->start_date }} to {{ $event->end_date }}.

    please, confirm your attendance by clicking on the button below.

@component('mail::button', ['url' => 'localhost:8000'])
Confirm Invitation
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
