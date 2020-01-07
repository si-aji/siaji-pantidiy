<div class="navbar-area navbar-one fixed-top w-100" style="position:fixed !important;z-index:9999;">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <nav class="navbar navbar-expand-lg">
                    <a class="navbar-brand" href="#">
                        <img src="{{ asset('ayro-ui/images/logo-4.svg') }}" alt="Logo">
                    </a>

                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarOne" aria-controls="navbarOne" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="toggler-icon"></span>
                        <span class="toggler-icon"></span>
                        <span class="toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse sub-menu-bar" id="navbarOne">
                        <ul class="navbar-nav m-auto">
                            <li class="nav-item">
                                <a class="active" href="#">ABOUT<button class="sub-nav-toggler"> <i class="lni-chevron-down"></i> </button></a>

                                <ul class="sub-menu">
                                    <li><a href="#">MENU ITEM 1</a></li>
                                    <li><a href="#">MENU ITEM 2 <i class="lni-chevron-right"></i><button class="sub-nav-toggler"> <i class="lni-chevron-down"></i> </button></a>
                                        <ul class="sub-menu">
                                            <li><a href="#">SUB MENU 1 <i class="lni-chevron-right"></i></a></li>
                                            <li><a href="#">SUB MENU 2</a></li>
                                            <li><a href="#">SUB MENU 3</a></li>
                                            <li><a href="#">SUB MENU 4</a></li>
                                            <li><a href="#">SUB MENU 5</a></li>
                                            <li><a href="#">SUB MENU 6</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="#">MENU ITEM 3</a></li>
                                    <li><a href="#">MENU ITEM 4</a></li>
                                    <li><a href="#">MENU ITEM 5</a></li>
                                    <li><a href="#">MENU ITEM 6</a></li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a href="#">SERVICES</a>
                            </li>
                            <li class="nav-item">
                                <a href="#">RESOURCES</a>
                            </li>
                            <li class="nav-item">
                                <a href="#">CONTACT</a>
                            </li>
                        </ul>
                    </div>

                    <div class="navbar-btn d-none d-sm-inline-block">
                        @guest
                        <ul>
                            <li><a class="light" href="{{ route('public.login') }}">Sign In</a></li>
                            <li><a class="solid" href="{{ route('public.register') }}">Sign Up</a></li>
                        </ul>
                        @else
                        <ul>
                            <li><a class="light" href="{{ route('dashboard.index') }}">Dashboard</a></li>
                        </ul>
                        @endguest
                    </div>
                </nav> <!-- navbar -->
            </div>
        </div> <!-- row -->
    </div> <!-- container -->
</div>