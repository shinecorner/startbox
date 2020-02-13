@extends('admin.layouts.backend.main')
@section('specific_vendor_header')
<link rel="stylesheet" type="text/css" href="/admin/app-assets/vendors/css/charts/morris.css">
@endsection

@section('content')
<div id="dashboard-module">
    <router-view></router-view>
</div>
@endsection

@section('specific_vendor_footer')
<script src="/admin/app-assets/vendors/js/charts/raphael-min.js"></script>
<script src="/admin/app-assets/vendors/js/charts/morris.min.js"></script>
<script src="/admin/app-assets/vendors/js/extensions/unslider-min.js"></script>
<script src="/admin/app-assets/vendors/js/timeline/horizontal-timeline.js"></script>
<script>
    $(document).ready(function () {
            $(".nav-item").removeClass("active");
            $('#dashboard').addClass('active');
        });
</script>
@endsection

@section('vue_modules')
<script src="{!! asset('admin/js/dashboard.js') !!}" type="text/javascript"></script>
<script>
    Morris.Bar({
        element: "monthly-sales",
        data: [{
            month: "Jan",
            sales: 1835
        }, {
            month: "Feb",
            sales: 2356
        }, {
            month: "Mar",
            sales: 1459
        }, {
            month: "Apr",
            sales: 1289
        }, {
            month: "May",
            sales: 1647
        }, {
            month: "Jun",
            sales: 2156
        }, {
            month: "Jul",
            sales: 1835
        }, {
            month: "Aug",
            sales: 2356
        }, {
            month: "Sep",
            sales: 1459
        }, {
            month: "Oct",
            sales: 1289
        }, {
            month: "Nov",
            sales: 1647
        }, {
            month: "Dec",
            sales: 2156
        }],
        xkey: "month",
        ykeys: ["sales"],
        labels: ["Sales"],
        barGap: 4,
        barSizeRatio: .3,
        gridTextColor: "#bfbfbf",
        gridLineColor: "#E4E7ED",
        numLines: 5,
        gridtextSize: 14,
        resize: !0,
        barColors: ["#00B5B8"],
        hideHover: "auto"
    });
</script>
@endsection