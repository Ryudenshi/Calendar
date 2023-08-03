@extends('layouts.app')

@php
$eventsRoute = route('events.index');
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



<script>
    var eventsRoute = '{{ $eventsRoute }}';

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
                }
            },
            header: {
                left: 'prev, next, today',
                center: 'title',
                right: 'ReminderButton, EventButton',
            },
            events: eventsRoute,
            eventClick: function(event) {

            }
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
                }
            });
        });
    });
</script>

@endsection