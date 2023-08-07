<!DOCTYPE html>
<html>

<head>
    <title>Event End Reminder</title>
</head>

<body>
    <h1>Event Start Reminder</h1>
    <p>Event "{{ $event->title }}" is about to end.</p>
    <p>End datetime: {{ $event->end_datetime }}</p>
</body>

</html>