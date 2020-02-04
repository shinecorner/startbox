@extends('admin.layouts.error.main')

@section('title')
{{env('APP_NAME')}} | 403
@endsection

@section('content')
    <div class="card-header bg-transparent border-0">
        <h2 class="error-code text-center mb-2">403</h2>
        <h3 class="text-uppercase text-center">Unauthorized Action</h3>
        <p>We are sorry, but you don't have the necessary permissions to access this resource.. <a href="{{ URL::previous() }}"><strong>Go back</strong></a></p>
    </div>
@endsection