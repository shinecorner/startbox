@extends('admin.layouts.backend.main')
@section('content')
<div id="dashboard-module">
	<router-view></router-view>
	{{-- <dashboard app_name="{{env('APP_NAME')}}"></dashboard> --}}
</div>
@endsection

@section('specific_vendor_footer')
<script src="/admin/app-assets/js/scripts/cards/card-statistics.min.js"></script>
<script>
    $(document).ready(function () {
            $(".nav-item").removeClass("active");
            $('#dashboard').addClass('active');
        });
</script>
@endsection

@section('vue_modules')
<script src="{!! asset('admin/js/dashboard.js') !!}" type="text/javascript"></script>
@endsection