<!DOCTYPE html>
<html lang="en">

<head>
    <title>First Step form</title>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <style>
        #searchResults {
            position: absolute;
            max-height: 200px;
            overflow-y: auto;
            background-color: #fff;
            border: 1px solid #ccc;
            border-top: none;
            display: none;
            z-index: 999;
            top: 60px;
        }
        #searchResults div {
            padding: 10px;
            cursor: pointer;
        }
        #searchResults div:hover {
            background-color: #f0f0f0;
        }
    </style>
</head>
<body>
    <main>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
              <a class="navbar-brand" href="#">Navbar</a>
              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                  <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">Home</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#">Link</a>
                  </li>
                </ul>
                <form class="d-flex">
                  <input class="form-control me-2" type="search"  id="searchInput" placeholder="Search by name or email" aria-label="Search">
                  <div id="searchResults"></div>
                  {{-- <button class="btn btn-outline-success" type="submit">Search</button> --}}
                </form>
              </div>
            </div>
          </nav>
        @yield('content')
        <!-- Modal -->
        <div class="modal fade" id="feesModal" tabindex="-1" role="dialog" aria-labelledby="feesModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="feesModalLabel">Pay Fees</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <form id="donationForm"  action="{{ route('donation.store') }}" method="post">
                <div class="modal-body">
                    @csrf
                    <input type="hidden" id="studentCode" name="first_form_id" value="1">
                    <div class="form-group">
                        <label for="class">Category Name:</label>
                        <input type="text" class="form-control" id="category_name" name="category_name">
                        <span class="text-danger error-message" id="category_name-error"></span>
                    </div>
                    <div class="form-group">
                        <label for="amount">Amount:</label>
                        <input type="number" class="form-control" id="amount" name="amount">
                        <span class="text-danger error-message" id="amount-error"></span>
                    </div>
                    <div class="form-group">
                        <label for="date">Date:</label>
                        <input type="date" class="form-control" id="date" name="donation_date">
                        <span class="text-danger error-message" id="donation_date-error"></span>

                    </div>
                    <div class="form-group">
                        <label for="payment_mode">payment_mode:</label>
                        <input class="form-control" id="payment_mode" name="payment_mode">
                        <span class="text-danger error-message" id="payment_mode-error"></span>
                    </div>
                    <div class="form-group">
                        <input class="form-check-input" type="checkbox" value="true" name="send_email" id="send_email">
                        <label class="form-check-label" for="send_email">
                            Send Email
                        </label>
                    </div>

                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" id="submitFees">Submit</button>
                </div>
            </form>
            </div>
            </div>
        </div>

    </main>
<script src="{{ asset('js/ajax/searchMember.js') }}"></script>
<script src="{{ asset('js/ajax/ajaxForm.js') }}"></script>
<script src="{{ asset('js/ajax/loadSweetAlertScript.js') }}"></script>
<script>
    var searchUrl = "{{ route('search') }}";
    $(document).on('click', '.payFees', function(e) {
        e.stopPropagation();
        var code = $(this).data('code');
        var name = $(this).data('name');
        $('#feesModal').find('#studentCode').val(code);
        $('#feesModal').find('.modal-title').text('Pay Fees for ' + name);
        $('#feesModal').modal('show');
    });
    /*
    |************************************************|
    |* Function to display success using SweetAlert *|
    |************************************************|
    */
    function successMessage(success){
        if(success !==''){
            Swal.fire({
                position: "center",
                icon: "success",
                title: "Data Uploaded",
                showConfirmButton: false,
                timer: 1500
            });
        }
    }

    /*
    |************************************************|
    |*** Function to insert data to the database ****|
    |************************************************|
    */
    submitAjaxForm('#donationForm', function(response) {
        $('#donationForm').trigger("reset");
        loadSweetAlertScript(function() {
            successMessage(response.message);
        });
        $('#feesModal').modal('hide');
    }, function(xhr, status, error) {
        var errors = xhr.responseJSON.errors;
        $.each(errors, function(key, value) {
            $('#' + key + '-error').text(value[0]);
        });
    });
</script>
</body>
</html>
