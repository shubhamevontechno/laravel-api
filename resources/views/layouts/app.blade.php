<!DOCTYPE html>
<html lang="en">

<head>
    <title>First Step form</title>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
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
                <div class="modal-body">
                <form id="feesForm">
                    <input type="hidden" id="studentCode" name="student_code">
                    <div class="form-group">
                    <label for="class">Class:</label>
                    <input type="text" class="form-control" id="class" name="class">
                    </div>
                    <div class="form-group">
                    <label for="amount">Amount:</label>
                    <input type="number" class="form-control" id="amount" name="amount">
                    </div>
                    <div class="form-group">
                    <label for="date">Date:</label>
                    <input type="date" class="form-control" id="date" name="date">
                    </div>
                    <div class="form-group">
                    <label for="description">Description:</label>
                    <textarea class="form-control" id="description" name="description"></textarea>
                    </div>
                </form>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="submitFees">Submit</button>
                </div>
            </div>
            </div>
        </div>

    </main>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="{{ asset('js/ajax/searchMember.js') }}"></script>
<script>
    var searchUrl = "{{ route('search') }}";
    $(document).on('click', '.payFees', function(e) {
        e.stopPropagation(); // Prevents closing of suggestions on button click
        var code = $(this).data('code');
        var name = $(this).data('name');
        // var name = $(this).siblings('span').text(); // Assuming student's name is displayed in a <span> element
            console.log('show name', name, code);
        // Populate name and code into the modal
        $('#feesModal').find('#studentCode').val(code);
        $('#feesModal').find('.modal-title').text('Pay Fees for ' + name);

        // Open the modal
        $('#feesModal').modal('show');
    });
</script>
</body>
</html>
