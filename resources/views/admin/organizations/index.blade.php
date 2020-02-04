@extends('admin.layouts.backend.main')
@section('content')
<div id="organization-module">
    <router-view></router-view>
</div>
@endsection

@section('specific_vendor_footer')
<script>
    $(document).ready(function () {
            $(".nav-item").removeClass("active");
            $('#organizations').addClass('active');

            toastr.options = {
            "closeButton": false,
            "debug": false,
            "newestOnTop": false,
            "progressBar": false,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
    }
        });
</script>
@endsection

@section('vue_modules')
<script src="{!! asset('admin/js/organization.js') !!}" type="text/javascript"></script>
@endsection