<script>
    var HOST_URL = "https://preview.keenthemes.com/metronic/theme/html/tools/preview";
</script>
<!--begin::Global Config(global config for global JS scripts)-->
<script>
    var KTAppSettings = {
        "breakpoints": {
            "sm": 576,
            "md": 768,
            "lg": 992,
            "xl": 1200,
            "xxl": 1400
        },
        "colors": {
            "theme": {
                "base": {
                    "white": "#ffffff",
                    "primary": "#3699FF",
                    "secondary": "#E5EAEE",
                    "success": "#1BC5BD",
                    "info": "#8950FC",
                    "warning": "#FFA800",
                    "danger": "#F64E60",
                    "light": "#E4E6EF",
                    "dark": "#181C32"
                },
                "light": {
                    "white": "#ffffff",
                    "primary": "#E1F0FF",
                    "secondary": "#EBEDF3",
                    "success": "#C9F7F5",
                    "info": "#EEE5FF",
                    "warning": "#FFF4DE",
                    "danger": "#FFE2E5",
                    "light": "#F3F6F9",
                    "dark": "#D6D6E0"
                },
                "inverse": {
                    "white": "#ffffff",
                    "primary": "#ffffff",
                    "secondary": "#3F4254",
                    "success": "#ffffff",
                    "info": "#ffffff",
                    "warning": "#ffffff",
                    "danger": "#ffffff",
                    "light": "#464E5F",
                    "dark": "#ffffff"
                }
            },
            "gray": {
                "gray-100": "#F3F6F9",
                "gray-200": "#EBEDF3",
                "gray-300": "#E4E6EF",
                "gray-400": "#D1D3E0",
                "gray-500": "#B5B5C3",
                "gray-600": "#7E8299",
                "gray-700": "#5E6278",
                "gray-800": "#3F4254",
                "gray-900": "#181C32"
            }
        },
        "font-family": "Poppins"
    };
</script>
<!--end::Global Config-->
<!--begin::Global Theme Bundle(used by all pages)-->
<script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
<script src="{{ asset('assets/plugins/custom/prismjs/prismjs.bundle.js') }}"></script>
<script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
<!--end::Global Theme Bundle-->
<!--begin::Page Vendors(used by this page)-->
<script src="{{ asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.js') }}"></script>
<!--end::Page Vendors-->
<!--begin::Page Scripts(used by this page)-->
<script src="{{ asset('assets/js/pages/widgets.js') }}"></script>
{{-- begin::sweetalert --}}
<script src="{{ asset('assets/js/pages/features/miscellaneous/sweetalert2.js') }}"></script>
{{-- end::sweetalert --}}
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    var toastMixin = Swal.mixin({
        toast: true,
        icon: 'success',
        title: 'General Title',
        position: 'top-right',
        showConfirmButton: false,
        timer: 3000,
    });

    window.addEventListener('close-modal', event => {
        $('#' + event.detail.id).modal('hide');
    })
    window.addEventListener('open-modal', event => {
        $('#' + event.detail.id).modal('show');
    })

    window.addEventListener('success-notification', event => {
        toastMixin.fire({
            title: event.detail.message,
            icon: 'success'
        });
    })

    window.addEventListener('info-notification', event => {
        toastMixin.fire({
            title: event.detail.message,
            icon: 'info'
        });
    })
    window.addEventListener('error-notification', event => {
        toastMixin.fire({
            title: event.detail.message,
            icon: 'error'
        });
    })
    window.addEventListener('warning-notification', event => {
        toastMixin.fire({
            title: event.detail.message,
            icon: 'warning'
        });
    })

    window.addEventListener('success-prompt', event => {
        Swal.fire(
            'Success!',
            event.detail.message,
            'success'
        )
    })

    window.addEventListener('error-prompt', event => {
        Swal.fire(
            'Error!',
            event.detail.message,
            'error'
        )
    })

    $('.logout-button').on('click', function(e) {
        e.preventDefault();
        submitLogoutForm();
    });

    function submitLogoutForm() {
        Swal.fire({
            title: 'Are you sure?',
            text: "You will be logged out of the system!",
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes, Log out!'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById("logout-form").submit();
            }
        })

    }
</script>
<!-- Include Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<!--end::Page Scripts-->
@stack('scripts')
@livewireScripts
</body>
<!--end::Body-->

</html>