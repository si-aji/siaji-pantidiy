<section class="header-area header-one">
    @include('layouts.partials.public.navbar')

    <div class="header-content-area d-flex align-items-center">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="header-wrapper">
                        <div class="header-content">
                            <h3 class="header-title">Social Care DIY</h3>
                            <p class="text">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book</p>
                            <div class="header-btn rounded-buttons">
                                <a class="main-btn rounded-one" href="#">DISCOVER MORE</a>
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