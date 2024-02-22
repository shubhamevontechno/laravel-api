function uploadImage(formId, url, containerId) {
    $(formId + ' input[type="file"]').change(function() {
        var formData = new FormData($(formId)[0]);

        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                console.log('get image res',response);
                $(containerId).html('<img src="' + response.image_url + '" alt="Uploaded Image" width="100px"><button type="button" class="btn btn-danger btn-sm">Del</button>');
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    });
}
