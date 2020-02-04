@extends('mail.layouts.classic')

@section('content')
    <p style="color: #444444">
        Hey {{ $user->first_name}}!
        <br /><br />

        <span>Thank you for signing up for <b>{{ config('company.name') }}</b></span>

        <span>STUFF</span>

        <br />
        <br />
        
        <span>Please, if you have any questions or feedback, let us know at: <a href="mailto: {{ config('company.email') }}" target="_top">{{ config('company.email') }}</a></span>
        <br />
        <br />
        
        <span>Cheers,</span>
        <br />
        <span>Team {{ config('company.name') }}</span>
    </p>
@endsection