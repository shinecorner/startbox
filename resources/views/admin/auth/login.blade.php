@extends('admin.layouts.plain.main')

@section('title')
{{env('APP_NAME')}} | Login
@endsection
@section('specific_vendor_header')
<!-- BEGIN: Page CSS-->
<link rel="stylesheet" type="text/css" href="/admin/app-assets/css/core/menu/menu-types/vertical-menu-modern.css">
<link rel="stylesheet" type="text/css" href="/admin/app-assets/css/core/colors/palette-gradient.min.css">
<link rel="stylesheet" type="text/css" href="/admin/app-assets/css/pages/login-register.min.css">
<!-- END: Page CSS-->
@endsection
@section('content')
<div id="auth-module">
	<login app_name="{{env('APP_NAME')}}"></login>
</div>
@endsection

@section('specific_vendor_footer')
<script src="/admin/app-assets/vendors/js/forms/validation/jqBootstrapValidation.js"></script>
<script src="/admin/app-assets/vendors/js/forms/icheck/icheck.min.js"></script>
<script src="/admin/app-assets/js/scripts/forms/form-login-register.min.js"></script>
@endsection

@section('vue_modules')
<script src="{!! asset('admin/js/auth.js') !!}" type="text/javascript"></script>
@endsection