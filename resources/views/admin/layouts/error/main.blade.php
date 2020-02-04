@include('admin.layouts.error.header')
<!-- BEGIN: Body-->
<body class="vertical-layout vertical-menu-modern 1-column blank-page blank-page" data-open="click" data-menu="vertical-menu-modern" data-col="1-column">
    <!-- BEGIN: Content-->
    <div class="app-content content">
      <div class="content-overlay"></div>
      <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <section class="flexbox-container">
                <div class="col-12 d-flex align-items-center justify-content-center">
                    <div class="col-12 box-shadow-2 p-0" style="max-width:450px; min-width:290px">
                        <div class="card border-grey border-lighten-3 px-1 py-1 m-0">
                            <div class="card-content">
                                @yield('content')
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
      </div>
    </div>
    <!-- END: Content-->
    @include('admin.layouts.plain.footer')


    <!-- BEGIN: Vendor JS-->
    <script src="/admin/app-assets/vendors/js/vendors.min.js"></script>
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
    @yield('specific_vendor_footer')
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="/admin/app-assets/js/core/app-menu.min.js"></script>
    <script src="/admin/app-assets/js/core/app.min.js"></script>
    <!-- END: Theme JS-->

    <!-- BEGIN: Page JS-->
    <script src="/admin/app-assets/js/scripts/forms/form-login-register.min.js"></script>
    <!-- END: Page JS-->

    <script type="text/javascript" src="{!! asset('admin/js/core.js') !!}" ></script>
    @yield('vue_modules')

  </body>
  <!-- END: Body-->
</html>