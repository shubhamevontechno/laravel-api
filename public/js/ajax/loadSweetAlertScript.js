function loadSweetAlertScript(callback) {
    if (typeof Swal === 'undefined') {
        var script = document.createElement('script');

        script.src = 'https://cdn.jsdelivr.net/npm/sweetalert2@11';

        script.onload = function() {
            if (callback) {
                callback();
            }
        };
        document.body.appendChild(script);
    } else {
        if (callback) {
            callback();
        }
    }
}
