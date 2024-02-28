function submitAjaxForm(formId, successCallback, errorCallback) {
  $(formId).submit(function (event) {
    event.preventDefault(); // Prevent default form submission
    var formData = $(this).serialize(); // Serialize form data
    $('.error-message').text('');
    var submitButton = $(this).find('button[type="submit"]');
    submitButton.prop("disabled", true);
    submitButton.html(
      '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...'
    );

    $.ajax({
      url: $(this).attr("action"), // Use form's action attribute as URL
      method: $(this).attr("method"), // Use form's method attribute as HTTP method
      data: formData,
      success: function (response) {
        console.log('get res',response);
        // Handle successful response
        // Re-enable the submit button and remove loading spinner after 2 seconds
        setTimeout(function () {
          if (successCallback) {
            successCallback(response);
          }
          submitButton.prop("disabled", false);
          submitButton.html("Submit");
        }, 500); // 2 seconds delay
      },
      error: function (xhr, status, error) {
        // Handle error response
        setTimeout(function () {
          submitButton.prop("disabled", false);
          submitButton.html("Submit");
          if (errorCallback) {
            errorCallback(xhr, status, error);
          }
        }, 500); // 2 seconds delay
      },
      complete: function () {},
    });
  });
}
