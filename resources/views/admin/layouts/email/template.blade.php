<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta name="viewport" content="width=device-width" />
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>{{env('APP_NAME')}} - @yield('title') </title>

	<style>
		#be-email-template-class p {
			color: #777777 !important; 
		}
		#be-email-template-class  h1,h2,h3, h4,h5,h6{
			color: inherit;
			word-wrap: normal !important;
			font-family: Helvetica, Arial, sans-serif;
			font-weight: normal !important;
		}
		#be-email-template-class h1 {
			font-size: 34px !important;
        }

		#be-email-template-class h2 {
			font-size: 30px !important;
        }

		#be-email-template-class h3 {
			font-size: 28px !important;
        }

		#be-email-template-class h4 {
			font-size: 24px !important;
        }

		#be-email-template-class h5 {
			font-size: 20px !important;
        }
		#be-email-template-class h6 {
			font-size: 18px !important;
        }
        #be-email-template-class hr {
			/*max-width: 480px;*/
			height: 0 !important;
			border-right: 0 !important;
			border-top: 0 !important;
			border-bottom: 1px solid #cacaca !important;
			border-left: 0 !important;
			margin: 15px 35px !important;
			clear: both ;
        }
		#be-email-template-class .text-capitalize {
			text-transform: capitalize !important;
        }
        #be-email-template-class .btn-primary {
            background: #6c757d;
            background-image: -webkit-linear-gradient(top, #6c757d, #6c757d) !important;
            background-image: -moz-linear-gradient(top, #6c757d, #6c757d) !important;
            background-image: -ms-linear-gradient(top, #6c757d, #6c757d) !important;
            background-image: -o-linear-gradient(top, #6c757d, #6c757d) !important;
            background-image: linear-gradient(to bottom, #6c757d, #6c757d) !important;
            -webkit-border-radius: 2 !important;
            -moz-border-radius: 2 !important;
            border-radius: 2px !important;
            font-family: Arial;
            color: #ffffff !important;
            font-size: 20px !important;
            padding: 10px 20px 10px 20px !important;
            text-decoration: none !important;
        }

        #be-email-template-class .btn-primary:hover {
            background: #5a6268 !important;
            background-image: -webkit-linear-gradient(top, #5a6268, #5a6268) !important;
            background-image: -moz-linear-gradient(top, #5a6268, #5a6268) !important;
            background-image: -ms-linear-gradient(top, #5a6268, #5a6268) !important;
            background-image: -o-linear-gradient(top, #5a6268, #5a6268) !important;
            background-image: linear-gradient(to bottom, #5a6268, #5a6268) !important;
            text-decoration: none !important;
        }
        #be-email-template-class .be-email-template-w15{
            width: 15px !important;
        }
        #be-email-template-class .be-email-template-w325{
            width: 325px !important;
        }
        #be-email-template-class .be-email-template-w580{
            width: 580px !important;
        }
        #be-email-template-class .be-email-template-w640{
            width: 640px !important;
            font-family:'Helvetica',sans-serif;
            border-collapse:collapse;
        }
        #be-email-template-class .m-0{
            margin:0 !important;
        }
        #be-email-template-class .m-10{
            margin:10px !important;
        }
        #be-email-template-class .m-15{
            margin:15px !important;
        }
        #be-email-template-class .m-25{
            margin:25px !important;
        }
        #be-email-template-class .m-35{
            margin:35px !important;
        }
        #be-email-template-class .m-t-0{
            margin-top:0 !important;
        }
        #be-email-template-class .m-t-10{
            margin-top:10px !important;
        }
        #be-email-template-class .m-t-15{
            margin-top:15px !important;
        }
        #be-email-template-class .m-t-25{
            margin-top:25px !important;
        }
        #be-email-template-class .m-t-35{
            margin-top:35px !important;
        }
        #be-email-template-class .m-b-0{
            margin-bottom:0 !important;
        }
        #be-email-template-class .m-b-10{
            margin-bottom:10px !important;
        }
        #be-email-template-class .m-b-15{
            margin-bottom:15px !important;
        }
        #be-email-template-class .m-b-25{
            margin-bottom:25px !important;
        }
        #be-email-template-class .m-b-35{
            margin-bottom:35px !important;
        }
        #be-email-template-class .m-l-0{
            margin-left:0 !important;
        }
        #be-email-template-class .m-l-10{
            margin-left:10px !important;
        }
        #be-email-template-class .m-l-15{
            margin-left:15px !important;
        }
        #be-email-template-class .m-l-25{
            margin-left:25px !important;
        }
        #be-email-template-class .m-l-35{
            margin-left:35px !important;
        }
        #be-email-template-class .m-r-0{
            margin-right:0 !important;
        }
        #be-email-template-class .m-r-10{
            margin-right:10px !important;
        }
        #be-email-template-class .m-r-15{
            margin-right:15px !important;
        }
        #be-email-template-class .m-r-25{
            margin-right:25px !important;
        }
        #be-email-template-class .m-r-35{
            margin-right:35px !important;
        }
        #be-email-template-class .p-0{
            padding:0 !important;
        }
        #be-email-template-class .p-10{
            padding:10px !important;
        }
        #be-email-template-class .p-15{
            padding:15px !important;
        }
        #be-email-template-class .p-25{
            padding:25px !important;
        }
        #be-email-template-class .p-35{
            padding:35px !important;
        }
        #be-email-template-class .p-t-0{
            padding-top:0 !important;
        }
        #be-email-template-class .p-t-10{
            padding-top:10px !important;
        }
        #be-email-template-class .p-t-15{
            padding-top:15px !important;
        }
        #be-email-template-class .p-t-25{
            padding-top:25px !important;
        }
        #be-email-template-class .p-t-35{
            padding-top:35px !important;
        }
        #be-email-template-class .p-b-0{
            padding-bottom:0 !important;
        }
        #be-email-template-class .p-b-10{
            padding-bottom:10px !important;
        }
        #be-email-template-class .p-b-15{
            padding-bottom:15px !important;
        }
        #be-email-template-class .p-b-25{
            padding-bottom:25px !important;
        }
        #be-email-template-class .p-b-35{
            padding-bottom:35px !important;
        }
        #be-email-template-class .p-l-0{
            padding-left:0 !important;
        }
        #be-email-template-class .p-l-10{
            padding-left:10px !important;
        }
        #be-email-template-class .p-l-15{
            padding-left:15px !important;
        }
        #be-email-template-class .p-l-25{
            padding-left:25px !important;
        }
        #be-email-template-class .p-l-35{
            padding-left:35px !important;
        }
        #be-email-template-class .p-r-0{
            padding-right:0 !important;
        }
        #be-email-template-class .p-r-10{
            padding-right:10px !important;
        }
        #be-email-template-class .p-r-15{
            padding-right:15px !important;
        }
        #be-email-template-class .p-r-25{
            padding-right:25px !important;
        }
        #be-email-template-class .p-r-35{
            padding-right:35px !important;
        }
        
	</style>

     @yield('specific_vendor_header')
</head>

<body id="be-email-template-class">
    <table id="be-email-template-background-table" style="table-layout:fixed;background-color:#ececec" width="100%" cellspacing="0" cellpadding="0" border="0" align="center">
        <tbody>
            <tr style="border-collapse:collapse">
                <td bgcolor="#ececec" align="center">
                    <table class="be-email-template-w640 m-t-0 m-b-0 m-r-10 m-l-10" width="640" cellspacing="0" cellpadding="0" border="0">
                        <tbody>
                            <tr style="border-collapse:collapse">
                                <td class="be-email-template-w640" width="640" height="20"></td>
                            </tr>
                            <tr style="border-collapse:collapse;">
                                <td id="be-email-template-header" class="be-email-template-w640" style="height: 110px;" width="640" bgcolor="#404E67" align="center">
                                    <div style="text-align:center;" align="center">
                                        @yield('header')
                                    </div>
                                </td>
                            </tr>
                            <tr style="border-collapse:collapse"><td class="be-email-template-w640" width="640" bgcolor="#ffffff" height="30"></td></tr>
                            <tr id="be-email-template-simple-content-row" style="border-collapse:collapse"><td class="be-email-template-w640" width="640" bgcolor="#ffffff">
                                    <table class="be-email-template-w640" width="640" cellspacing="0" cellpadding="0" border="0" align="left">
                                        <tbody><tr style="border-collapse:collapse">
                                                <td class="be-email-template-w30" width="30"></td>
                                                <td class="be-email-template-w580" width="580">

                                                    <table class="be-email-template-w580" width="580" cellspacing="0" cellpadding="0" border="0">
                                                        <tbody>
                                                            @yield('content')
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr style="border-collapse:collapse"><td class="be-email-template-w640" width="640" bgcolor="#ffffff" height="15"></td></tr>
                            <tr style="border-collapse:collapse">
                                <td class="be-email-template-w640" width="640">
                                    <table id="be-email-template-footer" class="be-email-template-w640" style="border-radius:0px 0px 6px 6px;" width="640" cellspacing="0" cellpadding="0" border="0" bgcolor="#ffffff">
                                        <tbody>
                                            <tr style="">
                                                <td class="be-email-template-w580">
                                                    <hr>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="be-email-template-w580" width="580">
                                                    @yield('footer')
                                                    <div style="text-align: center;margin-bottom: 5px;">
                                                        <a href="{{ env('APP_URL') }}" style="color: #535252;font-size:15px;">{{ env('APP_DOMAIN') }}</a>
                                                    </div>
                                                    <p id="be-email-template-street-address" style="font-size:11px;line-height:16px;margin-top:0px;margin-bottom:15px;color:#ffffff;white-space:normal" align="center">
                                                        <span></span><br style="line-height:100%">
                                                        <span><strong>Copyright</strong> {{env('APP_NAME')}} &copy; {{(date('Y') > 2020)?'2020 - '. date('Y'):'2020'}}</span>
                                                    </p>
                                                </td>
                                            </tr>
                                            <tr style="border-collapse:collapse"><td class="be-email-template-w580" width="580" height="10"></td></tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr style="border-collapse:collapse"><td class="be-email-template-w640" width="640" height="60"></td></tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>        
</body>

@yield('specific_vendor_footer')

</html>