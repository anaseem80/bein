$(document).ready(function() {
    if (success != null) {
        $('#toast-container').html(`
        <div class="position-fixed top-0 end-0 p-3" style="z-index: 11">
            <div id="liveToast" class="toast fade show" role="alert" aria-live="assertive" aria-atomic="true" style="margin-right: auto;">
                <div class="toast-header">
                    <button type="button" class="btn-close close-toast" data-bs-dismiss="toast"
                        aria-label="Close"></button>
                </div>
                <div class="toast-body text-center">
                    ${success}
                </div>
            </div>
        </div>
        `)
        var toastElList = [].slice.call(document.querySelectorAll('.toast'))
        var toastList = toastElList.map(function(toastEl) {
            return new bootstrap.Toast(toastEl)
        })
        setTimeout(function() {
            $('.close-toast').click();
        }, 3000)
    }
})