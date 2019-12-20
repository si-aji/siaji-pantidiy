<section class="header-area header-one mb-100">

    <div class="navbar-area navbar-one navbar-transparent">
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
                            <ul>
                                <li><a class="light" href="{{ route('public.login') }}">Sign In</a></li>
                                <li><a class="solid" href="#">Sign Up</a></li>
                            </ul>
                        </div>
                    </nav> <!-- navbar -->
                </div>
            </div> <!-- row -->
        </div> <!-- container -->
    </div>

    <div class="header-content-area d-flex align-items-center">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="header-wrapper">
                        <div class="header-content">
                            <h3 class="header-title">Unlimited Friendly &amp; Easy Customisable</h3>
                            <p class="text">Stop wasting time and money designing and managing a website that doesn’t get results. Happiness guaranteed!</p>
                            <div class="header-btn rounded-buttons">
                                <a class="main-btn rounded-one" href="#">DOWNLOAD NOW</a>
                            </div>
                            
                        </div> <!-- header content -->

                        <div class="header-image d-none d-lg-block">
                            <div class="image">
                                <img src="{{ asset('ayro-ui/images/header/header-1.png') }}" alt="Header">
                            </div>
                        </div>

                    </div>
                </div>
            </div> <!-- row -->
        </div> <!-- container -->
        <div class="header-shape">
            <img src="{{ asset('ayro-ui/images/header/header-shape-2.svg') }}" alt="shape">
        </div> <!-- header-shape -->
    </div> <!-- header content area -->
</section>