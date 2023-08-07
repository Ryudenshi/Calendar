<!DOCTYPE html>
<html>

<head>
    <title>Event Start Reminder</title>
</head>

<body>
    <h1>Event Start Reminder</h1>
    <p>Event "{{ $event->title }}" is starting soon.</p>
    <p>Start datetime: {{ $event->start_datetime }}</p>
</body>

</html>