<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('login_assets/css/bootstrap.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('login_assets/css/fontawesome-all.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('login_assets/css/iofrm-style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('login_assets/css/iofrm-theme4.css')}}">

</head>
<body>
<div class="form-body">
    <div class="website-logo">
        <a href="{{ route('login') }}">
            <div class="">
                <img class="logo-size" src="{{ asset('assets/images/login.png') }}" alt="">
            </div>
        </a>
    </div>
    <div class="row">
        <div class="img-holder">
            <div class="bg"></div>
            <div class="info-holder">
                <img src="{{ asset('assets/images/DSC_0206.JPG') }}" class="rounded" alt="">
            </div>
        </div>
        <div class="form-holder">
            <div class="form-content">
                <div class="form-items">
                    <h3>Get more things done with our IT Support.</h3>
                    <p>Please fill in the form below and submit to check status of your issue. <b>Use reference key sent to your email.</b></p>
                    <div>
                        @include('partials.form-status-login')

                    </div>
                    <div class="page-links">
                        <a href="{{ route('welcome') }}">Issue Ticket</a><a href="{{ route('follow') }}" class="active">Follow Up</a>
                    </div>
                    <form method="post" action="{{ route('postFollow') }}">
                        @csrf
                        @method('post')
                        <input class="form-control" type="text" name="reference_number" placeholder="e.g WTS1234" required>
                        <div class="form-button">
                            <button id="submit" type="submit" class="btn btn-danger">Search</button>
                        </div>
                    </form>

                    @if(isset($ticket))
                        <hr>
                        <h3>Ticket Details:</h3>
                        <p><b>Reference Key: </b> {{ $ticket->reference_key }}</p>
                        <p><b>Name: </b> {{ $ticket->name }}</p>
                        <p><b>Email: </b> {{ $ticket->email }}</p>
                        <p><b>Depot Name: </b> {{ $ticket->depot_name }}</p>
                        <p><b>Status: </b> {{ $ticket->status->value }}</p>
                        <p><b>Resolved By: </b> {{ $ticket->resolved_by }}</p>
                        <p><b>Description: </b> {{ $ticket->description }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('login_assets/js/jquery.min.js')}}"></script>
<script src="{{ asset('login_assets/js/popper.min.js')}}"></script>
<script src="{{ asset('login_assets/js/bootstrap.min.js')}}"></script>
<script src="{{ asset('login_assets/js/main.js')}}"></script>
</body>

</html>
