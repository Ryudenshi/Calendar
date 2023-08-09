@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center align-items-center">
        <div class="card" style="width: 300px;">
            <div class="row my-2 justify-content-center">
                <button type="button" style="width: 180px;" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#changeNameModal">
                    Change Name
                </button>
            </div>
            <div class="row my-2 justify-content-center">
                <button type="button" style="width: 180px;" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#changeEmailModal">
                    Change Email
                </button>
            </div>
            <div class="row my-2 justify-content-center">
                <button type="button" style="width: 180px;" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#changePassModal">
                    Change Password
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="changeNameModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Change Your Name</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="changeNameForm" action="{{ route('user.updateName') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="newName" class="form-label">New Name</label>
                        <input type="text" class="form-control" id="newName" name="new_name" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="changeEmailModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Change Your Email</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="changeEmailForm" action="{{ route('user.updateEmail') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="newEmail" class="form-label">New Email</label>
                        <input type="email" class="form-control" id="newEmail" name="new_email" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="changePassModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Change Your Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="changePassForm" action="{{ route('user.updatePassword') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="currentPassword" class="form-label">Current Password</label>
                        <input type="password" class="form-control" id="currentPassword" name="current_password" required>
                    </div>
                    <div class="mb-3">
                        <label for="newPassword" class="form-label">New Password</label>
                        <input type="password" class="form-control" id="newPassword" name="new_password" required>
                    </div>
                    <div class="mb-3">
                        <label for="confirmPassword" class="form-label">Confirm New Password</label>
                        <input type="password" class="form-control" id="confirmPassword" name="new_password_confirmation" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>

        </div>
    </div>
</div>

<script>
    $('#changeNameForm').on('submit', function(e) {
        e.preventDefault();

        var newName = $('#newName').val();
        var userId = $(this).data('user_id');

        $.ajax({
            type: "PUT",
            url: '{{ route("user.updateName") }}',
            data: {
                _token: '{{ csrf_token() }}',
                user_id: userId,
                name: newName
            },
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            success: function(response) {
                console.log(response);
                $('#changeNameModal').modal('hide');
            },
            error: function(xhr, textStatus, errorThrown) {
                console.error(xhr.responseText);
            }
        });
    });

    $('#changeNameForm').on('submit', function(e) {
        e.preventDefault();

        var newEmail = $('#newEmail').val();
        var userId = $(this).data('user_id');

        $.ajax({
            type: "PUT",
            url: '{{ route("user.updateEmail") }}',
            data: {
                _token: '{{ csrf_token() }}',
                user_id: userId,
                email: newEmail
            },
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            success: function(response) {
                console.log(response);
                $('#changeEmailModal').modal('hide');
            },
            error: function(xhr, textStatus, errorThrown) {
                console.error(xhr.responseText);
            }
        });
    });

    $('#changePassForm').on('submit', function(e) {
        e.preventDefault();

        var currentPassword = $('#currentPassword').val();
        var newPassword = $('#newPassword').val();
        var confirmPassword = $('#confirmPassword').val();

        $.ajax({
            type: "PUT",
            url: '{{ route("user.updatePassword") }}',
            data: {
                _token: '{{ csrf_token() }}',
                current_password: currentPassword,
                new_password: newPassword,
                new_password_confirmation: confirmPassword
            },
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            success: function(response) {
                console.log(response);
                $('#changePassModal').modal('hide');
            },
            error: function(xhr, textStatus, errorThrown) {
                console.error(xhr.responseText);
            }
        });
    });
</script>

@endsection