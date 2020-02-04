@extends('admin.layouts.plain.main')

@section('title')
	{{env('APP_NAME')}} | Reset Password
@endsection
@section('content')
	<div id="auth-module">
		<reset-password app_name="{{env('APP_NAME')}}"  token="{{ $token }}"  email="{{ $email }}"></reset-password>
	</div>
@endsection

@section('specific_vendor_footer')
    <script src="/admin/app-assets/vendors/js/forms/validation/jqBootstrapValidation.js"></script>
    <script src="/admin/app-assets/vendors/js/forms/icheck/icheck.min.js"></script>
@endsection

@section('vue_modules')
	<script src="{!! asset('admin/js/auth.js') !!}" type="text/javascript"></script>
@endsection