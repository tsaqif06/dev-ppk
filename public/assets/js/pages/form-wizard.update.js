$(document).ready(function () {
    $("#basic-pills-wizard").bootstrapWizard({
        tabClass: "nav nav-pills nav-justified",
        onLast: false,
        onNext: function (tab, navigation, index) {
            if (index >= 3) {
                submitActive()
                return
            }
        },
        onPrevious: function (tab, navigation, index) {
            submitNonActive()
        },

    })

});
var triggerTabList = [].slice.call(document.querySelectorAll(".twitter-bs-wizard-nav .nav-link"));
triggerTabList.forEach(function (a, index) {
    var r = new bootstrap.Tab(a);
    a.addEventListener("click", function (a) { a.preventDefault(), r.show() })
});

$('.nav-link').click(function () {
    var tab = $(this).attr('href')
    if (tab === '#dokumen-pendukung') {
        submitActive()
    } else {
        submitNonActive()
    }
});

function submitActive() {
    $('.next').addClass('d-none')
    $('.submit-form').removeClass('d-none')
}
function submitNonActive() {
    $('.next').removeClass('d-none')
    $('.submit-form').addClass('d-none')
}

