@component('mail::message')
# Event Reminder

Hello {{ $event->user->name }},

This is a reminder that the event "{{ $event->title }}" is about to begin on {{ $event->start_datetime }}.

Thank you,
Your App Team
@endcomponent