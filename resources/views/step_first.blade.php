<!DOCTYPE html>
<html lang="en">

<head>
    <title>First Step form</title>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session()->get('message') }}
            </div>
        @endif
        <div className="card">
            <form id="myForm" action="{{ route('step-form.store') }}" method="post">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="@error('name') is-invalid @enderror form-control" name="name"
                        id="name" placeholder="Your name" value="{{ old('name') }}">
                    <span class="text-danger error-message" id="name-error"></span>

                </div>
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Email address</label>
                    <input type="email" class="@error('email') is-invalid @enderror form-control" name="email"
                        id="exampleFormControlInput1" placeholder="name@example.com" value="{{ old('email') }}">
                    <span class="text-danger error-message" id="email-error"></span>

                </div>
                <div class="mb-3">
                    <button type="submit" class="btn btn-primary mb-3">Submit</button>
                </div>
            </form>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="{{ asset('js/ajax/ajaxForm.js') }}"></script>
    <script src="{{ asset('js/ajax/loadSweetAlertScript.js') }}"></script>
    <script>

        /*
        |************************************************|
        |* Function to display success using SweetAlert *|
        |************************************************|
        */
        function successMessage(success, redirect){
            console.log(redirect);
            if(success !==''){
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
        });
    </script>
</body>
</html>
