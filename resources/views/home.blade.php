@extends('layouts.app')

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

<div class="modal fade" id="eventModal" tabindex="-1" role="dialog" aria-labelledby="eventModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eventModalLabel">Add Event</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" id="closeEventButton">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="eventForm">
                    <div class="form-group">
                        <label for="eventTitle">Title</label>
                        <input type="text" class="form-control" id="eventTitle" placeholder="Event Title">
                    </div>
                    <div class="form-group">
                        <label for="eventDate">Date</label>
                        <input type="date" class="form-control" id="eventDate">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" id="closeEventButton">Close</button>
                <button type="button" class="btn btn-primary" id="saveEventButton">Save Event</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="reminderModal" tabindex="-1" role="dialog" aria-labelledby="reminderModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reminderModalLabel">Add Reminder</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" id="closeReminderButton">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="reminderForm">
                    <div class="form-group">
                        <label for="reminderTitle">Title</label>
                        <input type="text" class="form-control" id="reminderTitle" placeholder="Reminder Title">
                    </div>
                    <div class="form-group">
                        <label for="reminderDate">Date</label>
                        <input type="date" class="form-control" id="reminderDate">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" id="closeReminderButton">Close</button>
                <button type="button" class="btn btn-primary" id="saveReminderButton">Save Event</button>
            </div>
        </div>
    </div>
</div>

<script>
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
            }
        })

        $('#saveEventButton').on('click', function() {
            var title = $('#eventTitle').val();
            var date = $('#eventDate').val();

            $('#eventModal').modal('hide');
        });
        $('#closeEventButton').on('click', function() {
            $('#eventModal').modal('hide');
        });

        $('#saveReminderButton').on('click', function() {
            var title = $('#reminderTitle').val();
            var date = $('#reminderDate').val();

            $('#reminderModal').modal('hide');
        });
        $('#closeReminderButton').on('click', function() {
            $('#reminderModal').modal('hide');
        });
    });
</script>
@endsection