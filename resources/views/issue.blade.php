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
                <img src="{{ asset('assets/images/DSC_0206.JPG') }}" class="rounded" alt="Login" title="Login">
            </div>
        </div>
        <div class="form-holder">
            <div class="form-content">
                <div class="form-items">
                    <h3>Get more things done with our IT Support.</h3>
                    <p>Please fill in the form below to raise an issue.</p>
                    <div>
                        @include('partials.form-status-login')
                    </div>
                    <div class="page-links">
                        <a href="{{ route('welcome') }}" class="active">Issue Ticket</a><a href="{{ route('follow') }}">Follow
                            Up</a>
                    </div>
                    <form method="post" action="{{ url('/post-ticket') }}">
                        @csrf
                        <input class="form-control" type="text" name="name" placeholder="Full Name" required>

                        <input class="form-control" type="email" name="email" placeholder="E-mail Address" required>
                        <select name="depot_name" id="" class="form-control mb-3">
                            <option value="">Please select your depot</option>
                            @foreach($depots as $depot)
                                <option value="{{ $depot->name }}">{{ $depot->name }}</option>
                            @endforeach
                        </select>
                        <input class="form-control" type="text" name="contactable"
                               placeholder="e.g Anydesk Id or Phone Number or Email Address or Teamviewer" required>
                        <input class="form-control" type="text" name="subject" placeholder="Brief of the issue"
                               required>
                        <textarea class="form-control" name="description"
                                  placeholder="Give a detailed explanation of the issue" required></textarea>
                        <div class="form-button">
                            <button id="submit" type="submit" class="btn btn-danger">Submit Ticket</button>
                        </div>
                    </form>
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
