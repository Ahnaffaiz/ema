<!-- JAVASCRIPT -->
<script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('assets/libs/@popperjs/core/umd/popper.min.js') }}"></script>
<script src="{{ asset('assets/libs/feather-icons/feather.min.js') }}"></script>
<script src="{{ asset('assets/libs/metismenujs/metismenujs.min.js') }}"></script>
<script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>

<!-- Image Cropper -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css">

<!-- Plugins js-->
<script src="{{ asset('assets/libs/apexcharts/apexcharts.min.js') }}"></script>
<script src="{{ asset('assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
<script src="{{ asset('assets/libs/admin-resources/jquery.vectormap/maps/jquery-jvectormap-world-mill-en.js') }}"></script>
<script src="{{ asset('assets/libs/swiper/swiper-bundle.min.js') }}"></script>

<!-- dashboard init -->
<script src="{{ asset('assets/js/pages/dashboard.init.js') }}"></script>
<script src="{{ asset('assets/js/pages/nav&tabs.js') }}"></script>
<script src="{{ asset('assets/js/pages/login.init.js') }}"></script>

<!-- App js -->
<script src="{{ asset('assets/js/app.js') }}"></script>

<!-- Livewire Alert -->
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Alpine.js for interactive components -->
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

@livewireScripts
@stack('scripts')

<!-- Define swiperDir function for RTL support if not already defined -->
<script>
    // This function is needed for the RTL toggle in app.js
    if (typeof swiperDir !== 'function') {
        function swiperDir() {
            // Logic to handle swiper direction change for RTL/LTR
            if (document.querySelectorAll('.swiper-container').length > 0) {
                var swipers = document.querySelectorAll('.swiper-container');
                swipers.forEach(function(swiper) {
                    if (document.documentElement.getAttribute("dir") === "rtl") {
                        swiper.setAttribute("dir", "rtl");
                    } else {
                        swiper.setAttribute("dir", "ltr");
                    }
                    // Reinitialize swiper if needed
                    if (swiper.swiper) {
                        swiper.swiper.destroy();
                        swiper.swiper.init();
                    }
                });
            }
        }
    }
</script>
