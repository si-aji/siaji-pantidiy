<!-- ***** Blog Area Start ***** -->
<section class="fancy-blog-area section-padding-100-70" id="blog-area">
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
            <div class="col-12 col-md-4 blog-item">
                <div class="single-blog-area wow fadeInUp" data-wow-delay="0.5s">
                    <a href="{{ route('public.page.show', ['article', $article->post_slug]) }}" class="thumb-link">
                        <img class="blog-thumb" src="{{ !empty($article->post_thumbnail) ? asset('/img/post'.'/'.$article->post_thumbnail) : asset('no-image.jpg') }}" alt="">
                    </a>
                    <div class="blog-content">
                        <h5 class="blog-title">
                            <a href="{{ route('public.page.show', ['article', $article->post_slug]) }}">{{ $article->post_title }}</a>
                        </h5>

                        {!! str_limit(strip_tags($article->post_content), 250, '...') !!}
                        <a href="{{ route('public.page.show', ['article', $article->post_slug]) }}" class="blog-more">Read More <i class="fa fa-arrow-right"></i></a>
                    </div>
                    <div class="blog-info">
                        <small><span class="published-time"><i class="fa fa-clock-o"></i> {{ $article->post_published }}</span></small>
                    </div>
                </div>
            </div>
                @endforeach
                
                @if($article->count() >= 3)
            <a href="{{ route('public.page', ['article']) }}" class="blog-all">More Articles...</a>
                @endif
            @endif
        </div>
    </div>
</section>
<!-- ***** Blog Area End ***** -->