<!-- BEGIN: Body-->
@include ('admin.layouts.backend.header')

<body class="vertical-layout vertical-menu-modern 2-columns fixed-navbar" data-open="click"
    data-menu="vertical-menu-modern" data-col="2-columns">

    <div class="page-spinner-background" id="page-spinner">
        <div class="page-spinner">
            <div class="sk-cube-grid">
                <div class="sk-cube sk-cube1"></div>
                <div class="sk-cube sk-cube2"></div>
                <div class="sk-cube sk-cube3"></div>
                <div class="sk-cube sk-cube4"></div>
                <div class="sk-cube sk-cube5"></div>
                <div class="sk-cube sk-cube6"></div>
                <div class="sk-cube sk-cube7"></div>
                <div class="sk-cube sk-cube8"></div>
                <div class="sk-cube sk-cube9"></div>
            </div>
        </div>
    </div>


    @include ('admin.layouts.backend.top-menu')
    @include ('admin.layouts.backend.side-menu')

    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                @yield('content')
            </div>
        </div>
    </div>
    <!-- END: Content-->

    @include ('admin.layouts.backend.footer')

    <!-- BEGIN: Vendor JS-->
    <script src="/admin/app-assets/vendors/js/vendors.min.js"></script>
    <!-- BEGIN Vendor JS-->
    <script src="/admin/app-assets/vendors/js/extensions/toastr.min.js"></script>
    <script src="/admin/app-assets/vendors/js/extensions/sweetalert2.all.min.js"></script>
    <script src="/js/plugings/loadingoverlay.min.js"></script>
    <!-- BEGIN: Page Vendor JS-->
    <script src="/admin/app-assets/vendors/js/charts/apexcharts/apexcharts.min.js"></script>
    @yield('specific_vendor_footer')
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="/admin/app-assets/js/core/app-menu.min.js"></script>
    <script src="/admin/app-assets/js/core/app.min.js"></script>
    <script src="/admin/app-assets/js/scripts/customizer.min.js"></script>
    <!-- END: Theme JS-->
    <script type="text/javascript" src="{!! asset('admin/js/core.js') !!}"></script>
    @yield('vue_modules')
    <script type="text/javascript" src="{!! asset('admin/js/ui.js') !!}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
         toastr.options = {
             "closeButton": false,
             "debug": false,
             "newestOnTop": false,
             "progressBar": false,
             "positionClass": "toast-top-right",
             "preventDuplicates": false,
             "onclick": null,
             "showDuration": "300",
             "hideDuration": "1000",
             "timeOut": "5000",
             "extendedTimeOut": "1000",
             "showEasing": "swing",
             "hideEasing": "linear",
             "showMethod": "fadeIn",
             "hideMethod": "fadeOut"
        }
     });
    </script>

</body>
<!-- END: Body-->

</html>