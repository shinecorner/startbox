@include('admin.layouts.plain.header')
<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu-modern 1-column  bg-blue-grey bg-lighten-4 blank-page blank-page  pace-done"
    data-open="click" data-menu="vertical-menu-modern" data-col="1-column">
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
    <!-- BEGIN: Vendor JS-->
    <script src="/admin/app-assets/vendors/js/vendors.min.js"></script>
    <!-- BEGIN Vendor JS-->
    <script src="/js/plugings/loadingoverlay.min.js"></script>
    <script src="/admin/app-assets/vendors/js/extensions/sweetalert2.all.min.js"></script>
    <!-- BEGIN: Page Vendor JS-->
    @yield('specific_vendor_footer')
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="/admin/app-assets/js/core/app-menu.min.js"></script>
    <script src="/admin/app-assets/js/core/app.min.js"></script>
    <!-- END: Theme JS-->

    <script type="text/javascript" src="{!! asset('admin/js/core.js') !!}"></script>
    @yield('vue_modules')

</body>
<!-- END: Body-->

</html>