<!DOCTYPE html>
<html lang="en">
<head>
  <title>First Step form</title>
  <meta charset="utf-8">
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script> --}}
  {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script> --}}

</head>

<body>
<div class="container mt-3">
    <div id="example"></div>
    <div id="FormComponent"></div>
</div>
<script src="http://localhost:8097"></script>
{{-- <script>
   $(".submit-form").click(function(e){
        e.preventDefault();
        var data = $('#form-data').serialize();
        $.ajax({
            type: 'post',
            url: "{{ route('store') }}",
            data: data,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function(){
                $('#create_new').html('....Please wait');
            },
            success: function(response){
                console.log(response);
            },
            complete: function(response){
                $('#create_new').html('Create New');
            }
        });
	});
</script> --}}
</body>
</html>
