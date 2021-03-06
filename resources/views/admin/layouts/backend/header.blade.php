<html class="loading" lang="en" data-textdirection="ltr">
  <!-- BEGIN: Head-->
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="Stack admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
    <meta name="keywords" content="admin template, stack admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="PIXINVENT">
    
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    
    {{-- <link rel="apple-touch-icon" href="/admin/app-assets/images/ico/apple-icon-120.png"> --}}
    <link rel="shortcut icon" type="image/x-icon" href="/admin/app-assets/images/ico/favicon.ico">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i%7COpen+Sans:300,300i,400,400i,600,600i,700,700i" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="/admin/app-assets/vendors/css/vendors.min.css">
    <link rel="stylesheet" type="text/css" href="/admin/app-assets/vendors/css/extensions/toastr.css">
    <link rel="stylesheet" type="text/css" href="/admin/app-assets/vendors/css/extensions/sweetalert2.min.css">
    <!-- END: Vendor CSS-->

    {{-- Quill CSS --}}
    <link rel="stylesheet" type="text/css" href="../../../admin/app-assets/vendors/css/forms/quill/katex.min.css">
    <link rel="stylesheet" type="text/css" href="../../../admin/app-assets/vendors/css/forms/quill/monokai-sublime.min.css">
    <link rel="stylesheet" type="text/css" href="../../../admin/app-assets/vendors/css/forms/quill/quill.snow.css">
    <link rel="stylesheet" type="text/css" href="../../../admin/app-assets/vendors/css/forms/quill/quill.bubble.css">
    {{-- Quill CSS --}}

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="/admin/app-assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/admin/app-assets/css/bootstrap-extended.min.css">
    <link rel="stylesheet" type="text/css" href="/admin/app-assets/css/colors.min.css">
    <link rel="stylesheet" type="text/css" href="/admin/app-assets/css/components.min.css">
    <!-- END: Theme CSS-->

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="/admin/app-assets/css/core/menu/menu-types/vertical-menu-modern.css">
    <link rel="stylesheet" type="text/css" href="/admin/app-assets/css/core/colors/palette-gradient.min.css">
    <link rel="stylesheet" type="text/css" href="/admin/app-assets/fonts/simple-line-icons/style.min.css">
    <link rel="stylesheet" type="text/css" href="/admin/app-assets/css/pages/card-statistics.min.css">
    <link rel="stylesheet" type="text/css" href="/admin/app-assets/css/pages/vertical-timeline.min.css">
    <!-- END: Page CSS-->
    <link rel="stylesheet" type="text/css" href="/admin/app-assets/css/plugins/extensions/toastr.min.css">
    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="/admin/assets/css/style.css">
    <link rel="stylesheet" type="text/css" href="/admin/assets/css/style-override.css">
    <!-- END: Custom CSS-->

    @yield('specific_vendor_header')
    <link rel="stylesheet" href="{!! asset('admin/css/app.css') !!}" />

    {{-- Quill --}}
    <script src="{{ asset('admin/app-assets/vendors/js/forms/quill/highlight.min.js') }}"></script>
    <script src="{{ asset('admin/app-assets/vendors/js/forms/quill/quill.js') }}"></script>
    <script src="{{ asset('admin/app-assets/vendors/js/forms/quill/katex.min.js') }}"></script>
    {{-- End Quill --}}

  </head>
  <!-- END: Head-->