@extends('admin.layouts.error.main')

@section('title')
{{env('APP_NAME')}} | 404
@endsection

@section('content')
    <div class="card-header bg-transparent border-0">
        <h2 class="error-code text-center mb-2">404</h2>
        <h3 class="text-uppercase text-center">Page Not Found !</h3>
        <p>We are sorry, but the page you're looking for cannot be found. <a href="{{ URL::previous() }}"><strong>Go back</strong></a></p>
    </div>
@endsection