@extends('admin.layouts.backend.main')

@section('specific_vendor_header')
@endsection

@section('content')
<div id="admin-module">
    <router-view></router-view>
</div>
@endsection


@section('specific_vendor_footer')
<script>
    $(document).ready(function () {
            $(".nav-item").removeClass("active");
            $('#admins').addClass('active');
        });
</script>
@endsection
@section('vue_modules')
<script src="{!! asset('admin/js/admin.js') !!}" type="text/javascript"></script>
@endsection