@extends('mail.layouts.classic')

@section('content')
    <div style="color: #444444">
        <p>Hey {{ $user->first_name }}!</p>
        <p>Before you have full access, you'll need to confirm your email.</p>

        <a href="{!! $url !!}"
           style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;border-radius:3px;color:#fff;display:inline-block;text-decoration:none;background-color:#56b68b;border-top:10px solid #56b68b;border-right:18px solid #56b68b;border-bottom:10px solid #56b68b;border-left:18px solid #56b68b"
           target="_blank">
            <span class="il">Reset</span> <span class="il">Password</span>
        </a>

        <br />
        <p>If you did not request a password reset, please ignore this email.</p>
        <p>
            <span>Cheers,</span>
            <br />
            <span>{{ config('company.name') }} Team</span>
        </p>

        <p style="font-size: 11px;">
            <span>If the above button does not work please copy and paste the following URL into your web browser:</span>
            <a href="{!! $url !!}">{!! $url !!}</a>
        </p>
    </div>
@endsection