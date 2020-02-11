@extends('admin.layouts.backend.main')

@section('specific_vendor_header')
<link rel="stylesheet" type="text/css" href="/admin/app-assets/vendors/css/forms/selects/select2.min.css">
@endsection

@section('content')
<div id="location-module">
    <router-view :organizations="{{$organizations}}" :facilities="{{$facilities}}"></router-view>
</div>
@endsection


@section('specific_vendor_footer')
<script src="/admin/app-assets/vendors/js/forms/select/select2.full.min.js"></script>
<script>
    $(document).ready(function () {
            $(".nav-item").removeClass("active");
            $('#locations').addClass('active');
        });
</script>
@endsection
@section('vue_modules')
<script src="{!! asset('admin/js/location.js') !!}" type="text/javascript"></script>
@endsection