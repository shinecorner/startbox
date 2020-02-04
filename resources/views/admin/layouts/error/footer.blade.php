<footer class="footer footer-static footer-light navbar-border">
	<p class="clearfix blue-grey lighten-2 text-center mb-0 px-2 content">
		<span class="d-block d-md-inline-block">Copyright &copy; {{(date('Y') > 2020)?'2020 - '. date('Y'):'2020'}} <a href="{{env('APP_URL')}}" target="_blank" class="text-bold-800 grey darken-2">{{env('APP_NAME')}}</a>, All rights reserved.</span>
	</p>
</footer>