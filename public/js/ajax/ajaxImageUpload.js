/*
|----------------------------------------------|
|-----------------Upload Image-----------------|
|----------------------------------------------|
*/
function uploadImage(formId, url, containerId) {
    $(formId + ' input[type="file"]').change(function() {
        var formData = new FormData($(formId)[0]);
        formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success: function(response) {
                console.log('get image res',response);
                var imageUrl = response.image_url;
                console.log('get image url',imageUrl);
                var deleteUrl = '/delete-image'; // Assuming delete_url is provided in the response
                $(containerId).html('<div class="image-container" id="image-container"><img class="img-class" id="img-id" src="' + imageUrl + '" alt="Uploaded Image" width="100px"><button type="button" class="btn btn-danger btn-sm delete-btn" data-image-url="' + imageUrl + '" data-delete-url="' + deleteUrl + '">Del</button></div>');
                $('#image-url').val(imageUrl);
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    });
}

/*
|----------------------------------------------|
|-----------------Delete Image-----------------|
|----------------------------------------------|
*/
function deleteImage(imageUrl, deleteUrl, containerId, imageValue) {
    var csrfToken = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
        url: deleteUrl,
        type: 'POST',
        data: {
            _token: csrfToken,
            image_url: imageUrl
        },
        headers: {
            'X-CSRF-TOKEN': csrfToken
        },
        success: function(response) {
            setTimeout(() => {
                $('.delete-btn').text("Del");
                $(containerId).remove();
                $(imageValue).val('');
                $('#image-url').val('');
            }, 1000);
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
            $('.delete-btn').text("Del");
        }
    });
}

