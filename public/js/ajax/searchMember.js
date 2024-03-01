$(document).ready(function() {
    $('#searchInput').on('input', function() {
        var query = $(this).val();

        $.ajax({
            url: searchUrl,
            type: 'GET',
            data: {query: query},
            success: function(response) {
                $('#searchResults').empty();
                if(query){
                    if (response.length > 0) {
                        $.each(response, function(index, student) {
                            var listItem = '<div>' + student.name + ' (' + student.email + ')' +
                                '<button class="btn btn-info btn-sm payFees" data-name="' + student.name + '" data-code="' + student.email + '">Pay Fees</button>' +
                                '</div>';
                            $('#searchResults').append(listItem);
                        });
                        $('#searchResults').show();
                    } else {
                        $('#searchResults').hide();
                    }
            }
            }
        });
    });

    $(document).on('click', '.payFees', function() {
        var code = $(this).data('code');
        // Handle payment logic here
    });
});
