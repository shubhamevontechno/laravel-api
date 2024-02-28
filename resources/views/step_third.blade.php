<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Third  Step Form</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Third Step Form</div>
                    <div class="card-body">
                        <form id="myForm" enctype="multipart/form-data" action="{{ route('third-step-store') }}" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="qualification">qualification</label>
                                <input type="text" class="form-control" id="qualification" name="qualification">
                                <span class="text-danger error-message" id="qualification-error"></span>
                            </div>
                            <div class="form-group">
                                <label for="place">place:</label>
                                <input type="text" class="form-control" id="place" name="place">
                                <span class="text-danger error-message" id="place-error"></span>
                                <input type="text" name="first_form_id" id="first_form_id"
                                    value="{{ $get_id }}">
                            </div>
                            <div class="form-group">
                                <label for="image">Image</label>
                                <input type="file" class="form-control" id="member-image" name="image">
                                <input type="text" class="form-control" id="image-url" name="image">
                                 <!-- Display uploaded image here -->
                                <div id="imageContainer">
                                </div>
                                <span class="text-danger error-message" id="image-error"></span>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="{{ asset('js/ajax/ajaxForm.js') }}"></script>
    <script src="{{ asset('js/ajax/loadSweetAlertScript.js') }}"></script>
    <script src="{{ asset('js/ajax/ajaxImageUpload.js') }}"></script>
    <script>

        /*
        |************************************************|
        |***** Function to upload and display image *****|
        |************************************************|
        */
        $(document).ready(function() {
            uploadImage('#myForm', '/upload', '#imageContainer');
        });

        /*
        |************************************************|
        |**** Function to delete the displayed image ****|
        |************************************************|
        */
        $(document).on('click', '.delete-btn', function() {
            var loaderUrl = '{{ asset("assets/loader/spinner-4.svg") }}';
            var imageUrl = $(this).data('image-url');
            var deleteUrl = $(this).data('delete-url');
            var containerId = '#' + $(this).closest('.image-container').attr('id');
            var imageValue = '#member-image';
            $(this).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>');
            deleteImage(imageUrl, deleteUrl, containerId, imageValue);
        });

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
        function successMessage(success, redirect){
            if(success !==''){
                Swal.fire({
                    position: "center",
                    icon: "success",
                    title: success,
                    showConfirmButton: false,
                    timer: 1500
                }).then(function(){
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
            var nextFormUrl = '/step-form';
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

</body>

</html>
