<nav class="navbar header-navbar pcoded-header">
    <div class="navbar-wrapper">
        <div class="navbar-logo">
            <a href="{{ url('/home') }}">
                <img class="img-fluid" src="{{ asset('dash_resource\png\top_logo_small.png') }}"
                    alt="{{ config('app.name', 'Laravel') }}" />
            </a>
            <a class="mobile-menu" id="mobile-collapse" href="#!">
                <i class="feather icon-menu icon-toggle-right"></i>
            </a>
            <a class="mobile-options waves-effect waves-light">
                <i class="feather icon-more-horizontal"></i>
            </a>
        </div>
        <div class="navbar-container container-fluid">
            <ul class="nav-left">
                <li>
                    <a href="#!"
                        onclick="if (!window.__cfRLUnblockHandlers) return false; javascript:toggleFullScreen()"
                        class="waves-effect waves-light" data-cf-modified-d8424a08d31b5b8b406fded2-="">
                        <i class="full-screen feather icon-maximize"></i>
                    </a>
                </li>
            </ul>
            <ul class="nav-right">
                @guest

                @else

                @php
                    $count1 = \App\Models\FoodRequest::where('status','not approved')->count();
                    $count2 = \App\Models\MeatRequest::where('status','not approved')->count();
                    $notifications = \App\Models\FoodRequest::where('status','=','not approved')->limit(5)->latest()->get();
                    $meats = \App\Models\MeatRequest::where('status','=','not approved')->limit(5)->latest()->get();
                @endphp

                @if (Auth::user()->hasRole('admin'))
                    <li class="header-notification">
                        <div class="dropdown-primary dropdown">
                        <div class="dropdown-toggle" data-toggle="dropdown">
                            <i class="feather icon-bell"></i>
                            <span class="badge bg-c-red">{{ $count1 }}</span>
                        </div>
                        <ul
                            class="show-notification notification-view dropdown-menu"
                            data-dropdown-in="fadeIn"
                            data-dropdown-out="fadeOut"
                        >
                            <li>
                            <h6>Food request notifications</h6>
                            <label class="label label-primary"><a style="color: white;" href="{{ url('/pending-requests')}}">View All</a></label>
                            </li>

                            @if ($count1 > 0)
                                @foreach ($notifications as $item)
                                    <li>
                                        <div class="media">
                                            <span class="pcoded-micon pr-3 pt-3"><i class="fa fa-sign-out"></i></span>
                                            <div class="media-body">
                                                <h5 class="notification-user">{{ $item->user->full_name }}</h5>
                                                <p class="notification-msg">Submitted a request pending approval. <a style="color:aliceblue;" class="btn btn-round btn-primary btn-sm " href="{{ route('notify.food',$item->id)}}">Show</a></p>
                                                <span class="notification-time">Submitted at {{ $item->created_at->format('H:i:s') }}</span>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            @else
                                <li>
                                    <div class="media">
                                        <div class="media-body">
                                            <p class="notification-msg"> No new notifications</p>
                                        </div>
                                    </div>
                                </li>
                            @endif
                        </ul>
                        </div>
                    </li>

                    <li class="header-notification">
                        <div class="dropdown-primary dropdown">
                        <div class="dropdown-toggle" data-toggle="dropdown">
                            <i class="feather icon-message-square"></i>
                            <span class="badge badge bg-c-green">{{ $count2 }}</span>
                        </div>
                        <ul
                            class="show-notification notification-view dropdown-menu"
                            data-dropdown-in="fadeIn"
                            data-dropdown-out="fadeOut"
                        >
                            <li>
                            <h6>Meat request notifications</h6>
                            <label class="label label-primary"><a style="color: white;" href="{{ url('/pending-meat-requests')}}">View All</a></label>
                            </li>

                            @if ($count2 > 0)
                                @foreach ($meats as $item)
                                    <li>
                                        <div class="media">
                                            <span class="pcoded-micon pr-3 pt-3"><i class="fa fa-sign-out"></i></span>
                                            <div class="media-body">
                                                <h5 class="notification-user">{{ $item->user->full_name }}</h5>
                                                <p class="notification-msg">Submitted a request pending approval. <a style="color:aliceblue;" class="btn btn-round btn-primary btn-sm " href="{{ route('notify.meat',$item->id)}}">Show</a></p>
                                                <span class="notification-time">Submitted at {{ $item->created_at->format('H:i:s') }}</span>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            @else
                                <li>
                                    <div class="media">
                                        <div class="media-body">
                                            <p class="notification-msg"> No new notifications</p>
                                        </div>
                                    </div>
                                </li>
                            @endif
                        </ul>
                        </div>
                    </li>
                @endif

                <li class="user-profile header-notification">
                    <div class="dropdown-primary dropdown">
                        <div class="dropdown-toggle" data-toggle="dropdown">
                            <span>{{ Auth::user()->full_name }}</span>
                            <i class="feather icon-chevron-down"></i>
                        </div>
                        <ul class="show-notification profile-notification dropdown-menu" data-dropdown-in="fadeIn"
                            data-dropdown-out="fadeOut">
                            <li>
                                <a href="{{ url('users/'.Auth::user()->id) }}">
                                    <i class="feather icon-user"></i> Profile
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    <i class="feather icon-log-out"></i> Logout
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </div>
                </li>
                @endguest

            </ul>
        </div>
    </div>
</nav>
