@extends('layouts.app')
@section('content')
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Second Step Form</div>
                    <div class="card-body">
                        <form id="myForm" action="{{ route('second-step-store') }}" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="dob">Date of Birth:</label>
                                <input type="date" class="form-control" id="dob" name="dob">
                                <span class="text-danger error-message" id="dob-error"></span>
                            </div>
                            <div class="form-group">
                                <label for="phone">Phone:</label>
                                <input type="number" class="form-control" id="phone" name="phone">
                                <span class="text-danger error-message" id="phone-error"></span>
                                <input type="text" name="first_form_id" id="first_form_id" value="{{ $get_id }}">
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/ajax/ajaxForm.js') }}"></script>
    <script src="{{ asset('js/ajax/loadSweetAlertScript.js') }}"></script>
    <script>
        /*
            |************************************************|
            |** Function to display error using SweetAlert **|
            |************************************************|
            */
        function displayError(errors) {
            var errorMessage = '';

            if (errors.integrity_constraint_violation) {
                errorMessage += errors.integrity_constraint_violation[0] + '\n';
            }

            if (errors.first_form_id) {
                errorMessage += errors.first_form_id[0];
            }

            if (errorMessage !== '') {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: errorMessage,
                    confirmButtonText: 'OK'
                });
            }
        }

        /*
        |************************************************|
        |* Function to display success using SweetAlert *|
        |************************************************|
        */
        function successMessage(success, redirect) {
            if (success !== '') {
                Swal.fire({
                    position: "center",
                    icon: "success",
                    title: success,
                    showConfirmButton: false,
                    timer: 1500
                }).then(function() {
                    window.location.href = redirect;
                });
            }
        }

        /*
        |************************************************|
        |*** Function to insert data to the database ****|
        |************************************************|
        */
        submitAjaxForm('#myForm', function(response) {
            var lastInsertedId = response.lastInsertedId;
            var nextFormUrl = '/second-form/' + lastInsertedId;

            loadSweetAlertScript(function() {
                successMessage(response.message, nextFormUrl);
            });

        }, function(xhr, status, error) {
            var errors = xhr.responseJSON.errors;
            $.each(errors, function(key, value) {
                $('#' + key + '-error').text(value[0]);
            });
            if (errors.integrity_constraint_violation || errors.first_form_id) {
                loadSweetAlertScript(function() {
                    displayError(errors);
                });
            }
        });
    </script>
@endsection()
