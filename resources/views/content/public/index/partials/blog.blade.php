<!-- ***** Blog Area Start ***** -->
<section class="fancy-blog-area section-padding-100-70">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-heading text-center">
                    <h2>Latest Article</h2>
                    <p>Some latest article that we wrote.</p>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Blog Content -->
            @if($articles->isNotEmpty())
                @foreach($articles as $article)
            <div class="col-12 col-md-4">
                <div class="single-blog-area wow fadeInUp" data-wow-delay="0.5s">
                    <img src="{{ asset('fancy/img/blog-img/blog-1.jpg') }}" alt="">
                    <div class="blog-content">
                        <h5>
                            <a href="{{ route('public.page', ['article', $article->post_slug]) }}">{{ $article->post_title }}</a>
                        </h5>

                        {!! strip_tags(str_limit($article->post_content, 250, ' ...')) !!}
                        <a href="{{ route('public.page', ['article', $article->post_slug]) }}">Learn More</a>
                    </div>
                </div>
            </div>
                @endforeach
            @endif
        </div>
    </div>
</section>
<!-- ***** Blog Area End ***** -->