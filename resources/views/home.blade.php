@extends('layouts.app')

@php
$eventsRoute = route('events.index');
$remindersRoute = route('reminders.index');
@endphp

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="row" id="calendar"></div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="createEventModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createEventModalLabel">Create Event</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('events.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="event-title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="event-title" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="event-color" class="form-label">Color</label>
                        <input type="text" class="form-control" id="event-color" name="color" required>
                    </div>
                    <div class="mb-3">
                        <label for="event-start-datetime" class="form-label">Event start data time</label>
                        <input type="datetime-local" class="form-control" id="event-start-datetime" name="start_datetime" required>
                    </div>
                    <div class="mb-3">
                        <label for="event-end-datetime" class="form-label">Event end data time</label>
                        <input type="datetime-local" class="form-control" id="event-end-datetime" name="end_datetime" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Create</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="reminderModal" tabindex="-1" aria-labelledby="createReminderModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createReminderModalLabel">Create Reminder</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('reminders.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="reminder-title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="reminder-title" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="reminder-color" class="form-label">Color</label>
                        <input type="text" class="form-control" id="reminder-color" name="color" required>
                    </div>
                    <div class="mb-3">
                        <label for="reminder-datetime" class="form-label">Reminder data time</label>
                        <input type="datetime-local" class="form-control" id="reminder-datetime" name="datetime" required>
                    </div>
                    <div class="mb-3">
                        <label for="reminder-repeat-type" class="form-label">Repeate type</label>
                        <select class="form-select" id="reminder-repeat-type" name="repeat_type">
                            <option value="none">no repeats</option>
                            <option value="daily">Daily</option>
                            <option value="weekly">Weekly</option>
                            <option value="monthly">Monthly</option>
                            <option value="yearly">Yearly</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Create</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="updateEventModal" tabindex="-1" aria-labelledby="updateEventModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateEventModalLabel">Update Event</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="updateEventForm" action="" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="update-event-id" class="form-label">Select Event to Update</label>
                        <select class="form-select" id="update-event-id" name="event_id"></select>
                    </div>
                    <div class="mb-3">
                        <label for="update-event-title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="update-event-title" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="update-event-color" class="form-label">Color</label>
                        <input type="text" class="form-control" id="update-event-color" name="color" required>
                    </div>
                    <div class="mb-3">
                        <label for="update-event-start-datetime" class="form-label">Event start data time</label>
                        <input type="datetime-local" class="form-control" id="update-event-start-datetime" name="start_datetime" required>
                    </div>
                    <div class="mb-3">
                        <label for="update-event-end-datetime" class="form-label">Event end data time</label>
                        <input type="datetime-local" class="form-control" id="update-event-end-datetime" name="end_datetime" required>
                    </div>
                    <input type="hidden" name="completed" value="false" required>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
    var eventsRoute = '{{ $eventsRoute }}';
    var remindersRoute = '{{ $remindersRoute }}';

    $.ajax({
        url: eventsRoute,
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            var dropdown = $('#update-event-id');
            dropdown.empty();
            $.each(response, function(index, event) {
                dropdown.append($('<option></option>').attr('value', event.id).text(event.title));
            });
        }
    });

    $(document).ready(function() {
        $('#calendar').fullCalendar({

            customButtons: {
                EventButton: {
                    text: '+ event',
                    click: function() {
                        $('#eventModal').modal('show');
                    }
                },

                ReminderButton: {
                    text: '+ reminder',
                    click: function() {
                        $('#reminderModal').modal('show');
                    }
                },

                EventUpdateButton: {
                    text: '+ update Event',
                    click: function() {
                        $('#updateEventModal').modal('show');
                    }
                },
                ReminderUpdateButton: {
                    text: '+ update a Reminder',
                    click: function() {
                        $('#updateEventForm').attr('action', eventsRoute + '/' + event.id);
                        $('#update-event-title').val(event.title);
                        $('#update-event-color').val(event.color);
                        $('#update-event-start-datetime').val(event.start.format('YYYY-MM-DDTHH:mm'));
                        $('#update-event-end-datetime').val(event.end.format('YYYY-MM-DDTHH:mm'));

                        $('#updateReminderModal').modal('show');
                    }
                },
            },

            eventRender: function(event, element) {
                if (event.completed) {
                    element.css('text-decoration', 'line-through');
                } else {
                    element.css('text-decoration', 'none');
                }
            },

            header: {
                left: 'prev, next, today',
                center: 'title',
                right: 'ReminderButton, EventButton',
            },

            footer: {
                left: 'EventUpdateButton, ReminderUpdateButton',
            },

            events: eventsRoute,

            eventClick: function(event) {
                var isCompleted = !event.completed;
                $.ajax({
                    type: "PUT",
                    url: eventsRoute + '/' + event.id, // Use event ID here
                    data: {
                        title: event.title,
                        color: event.color,
                        start_datetime: event.start.format(),
                        end_datetime: event.end.format(),
                        completed: isCompleted ? 1 : 0,
                        _token: '{{ csrf_token() }}',
                    },
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        event.completed = isCompleted;
                        $('#calendar').fullCalendar('updateEvent', event);
                    },
                    error: function(xhr, textStatus, errorThrown) {
                        console.error(xhr.responseText);
                    }
                });
            },

            eventSources: [{
                url: remindersRoute,
            }]
        });

        $('#eventForm').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: $(this).attr('action'),
                data: $(this).serialize(),
                success: function(response) {
                    $('#eventModal').modal('hide');
                    $('#calendar').fullCalendar('renderEvent', response.event, true);
                },
                error: function(xhr, textStatus, errorThrown) {
                    console.error(xhr.responseText);
                }
            });
        });

        $('#reminderForm').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: $(this).attr('action'),
                data: $(this).serialize(),
                success: function(response) {
                    $('#reminderModal').modal('hide');
                    $('#calendar').fullCalendar('renderEvent', response.reminder, true);
                },
                error: function(xhr, textStatus, errorThrown) {
                    console.error(xhr.responseText);
                }
            });
        });

        $('#updateEventForm').on('submit', function(e) {
            e.preventDefault();
            var formData = $(this).serialize();
            console.log('Form Data:', formData);
            $.ajax({
                type: "POST",
                url: 'events/' + $('#update-event-id').val(),
                data: formData,
                success: function(response) {
                    $('#updateEventModal').modal('hide');
                    $('#calendar').fullCalendar('refetchEvents');
                },
                error: function(xhr, textStatus, errorThrown) {
                    console.error(xhr.responseText);
                }
            });
        });
    });
</script>

@endsection