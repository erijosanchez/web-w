<header id="header" class="header">
    <div class="top-left">
        <div class="navbar-header">
            <a class="navbar-brand" href="{{ route('admin.dashboard')}}"><img src="{{ asset('assets/backend/images/logo.png')}}" alt="Logo"></a>
            <a class="navbar-brand hidden" href="{{ route('admin.dashboard')}}"><img src="{{ asset('assets/backend/images/logo2.png')}}" alt="Logo"></a>
            <a id="menuToggle"><i class="fa fa-bars"></i></a>
        </div>
    </div>
    <div class="top-right">
        <div class="header-menu">
            <div class="header-left">
                <button class="search-trigger"><i class="fa fa-search"></i></button>
                <div class="form-inline">
                    <form class="search-form">
                        <input class="form-control mr-sm-2" type="text" placeholder="Search ..." aria-label="Search">
                        <button class="search-close" type="submit"><i class="fa fa-close"></i></button>
                    </form>
                </div>

                <div class="dropdown for-notification">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="notification" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-bell"></i>
                        <span class="count bg-danger">2</span>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="notification">
                        <p class="red">You have 2 Notification</p>
                        <a class="dropdown-item media" href="#">
                            <i class="fa fa-check"></i>
                            <p>Server #1 overloaded.</p>
                        </a>
                    </div>
                </div>

                <div class="dropdown for-message">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="message" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-envelope"></i>
                        <span class="count bg-primary">4</span>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="message">
                        <p class="red">You have 4 Mails</p>
                        <a class="dropdown-item media" href="#">
                            <span class="photo media-left"><img alt="avatar" src=" {{ asset('assets/backend/images/avatar/1.jpg')}}"></span>
                            <div class="message media-body">
                                <span class="name float-left">Jonathan Smith</span>
                                <span class="time float-right">Just now</span>
                                <p>Hello, this is an example msg</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <div class="user-area dropdown float-right">
                <a href="#" class="dropdown-toggle active" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="user-avatar rounded-circle" src="{{ $admin->profile_photo_url ?? asset('assets/backend/images/admin.jpg')}}"
                    alt="User Avatar">
                </a>

                <div class="user-menu dropdown-menu">
                    <a class="nav-link" href="{{ route('admin.profile')}} "><i class="fa fa- user"></i>Mi Perfil</a>

                    <a class="nav-link" href="#"><i class="fa fa- user"></i>Notifications <span class="count">13</span></a>

                    <a class="nav-link" href="#"><i class="fa fa -cog"></i>Settings</a>

                    <a class="nav-link" href="{{ route('admin.logout')}}"><i class="fa fa-power -off"></i>Logout</a>
                </div>
            </div>

        </div>
    </div>
</header>

