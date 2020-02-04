@extends('admin.layouts.backend.main')
@section('content')
<div id="user-module">
    <router-view :roles="[]"></router-view>
</div>
@endsection

@section('specific_vendor_footer')
<script>
    $(document).ready(function () {
            $(".nav-item").removeClass("active");
            $('#users').addClass('active');
        });
</script>
@endsection

@section('vue_modules')
<script src="{!! asset('admin/js/user.js') !!}" type="text/javascript"></script>
@endsection