<section class="article-area article-one">
    <div class="container">
        <div class="row">
            {{-- Article --}}
            <div class="col-12 col-md-6 col-lg-8">
                <div class="section-title pb-10">
                    <h4 class="title">Article</h4>
                    <p class="text">Read some article that we made!</p>
                </div> <!-- section title -->

                <div class="card card-blog card-higlight">
                    <div class="card-body">
                        <img class="blog-img" src="{{ asset('ayro-ui/images/b8.jpg') }}" alt="Card image cap">
                        <div class="blog-content">
                            <h5 class="card-title">Card title</h5>
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                        </div>
                    </div>
                    <div class="card-footer d-table rounded-buttons">
                        <span class="d-table-cell" style="vertical-align: middle"><i class="lni-calendar"></i> Mar 23, 2022</span>
                        <a href="#" class="main-btn rounded-one btn-sm float-right">Go somewhere</a>
                    </div>
                </div>

                <div class="row">
                    @for($i = 0; $i < 4; $i++)
                    <div class="col-12 col-md-6">
                        <div class="card card-blog">
                            <img class="card-img-top" src="{{ asset('ayro-ui/images/b8.jpg') }}" alt="Card image cap">
                            <div class="card-body rounded-buttons">
                                <h5 class="card-title">Card title</h5>
                                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                                <a href="#" class="main-btn rounded-one float-right mt-3">Go somewhere</a>
                            </div>
                            <div class="card-footer d-table">
                                <span class="d-table-cell" style="vertical-align: middle"><i class="lni-calendar"></i> Mar 23, 2022</span>
                            </div>
                        </div>
                    </div>
                    @endfor
                </div>
            </div>{{-- /.Article --}}

            {{-- Event --}}
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card card-event">
                    <div class="card-body">
                        <h5 class="card-title">Event Title</h5>
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                        <span class="d-block"><i class="lni-calendar"></i> Mar 23, 2022</span>
                    </div>
                </div>
            </div>{{-- /.Event --}}
        </div>
    </div>
</section>