@extends('admin.layouts.backend.main')
@section('content')
<div id="page-module">
    <router-view ></router-view>
</div>
@endsection

@section('specific_vendor_footer')
<script>
    $(document).ready(function () {
            $(".nav-item").removeClass("active");
            $('#pages').addClass('active');
        });
</script>
@endsection

@section('vue_modules')
<script src="{!! asset('admin/js/page.js') !!}" type="text/javascript"></script>
@endsection