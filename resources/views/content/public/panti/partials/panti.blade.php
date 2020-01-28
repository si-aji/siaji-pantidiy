@if($panti->isNotEmpty())
    @foreach($panti as $value)
    <div class="panti-container d-sm-flex mb-4">
        <div class="panti-thumb">
            <img src="{{ count($value->pantiGallery) > 0 ? asset('img/panti'.'/'.$value->pantiGallery[0]->gallery_fullname) : asset('no-image.jpg') }}" alt="">
        </div>
        <div class="panti-content media-body">
            <a href="{{ route('public.panti.show', $value->panti_slug) }}" class="panti-title">
                {{ $value->panti_name }}
            </a>
            <div class="panti-subtitle">
                {{ $value->pantiLiputan()->count() ? $value->pantiLiputan()->count().' Liputan' : 'Belum ada Liputan' }}
            </div>
            <div class="panti-desc">
                {{-- Desc --}}
                {!! !empty($value->panti_description) ? strip_tags(str_limit($value->panti_description, 175, ' ...')) : 'No Description Provided' !!}
            </div>
        </div>
    </div>
    @endforeach

    @if($panti->hasPages())
    <div class="fancy-paginate">
        <nav>
            <ul class="pagination">
                <li class="page-item {{ $panti->onFirstPage() ? 'disabled' : '' }}" @if($panti->onFirstPage()) aria-disabled="true" @endif>
                    @if($panti->onFirstPage())
                    <span class="page-link">« Previous</span>
                    @else
                    <a class="page-link" href="{{ $panti->appends(request()->input())->previousPageUrl() }}" rel="previous">« Previous</a>
                    @endif
                </li>
                
                <li class="page-item {{ $panti->hasMorePages() ? '' : 'disabled' }}" @if(!$panti->hasMorePages()) aria-disabled="true" @endif>
                    @if($panti->hasMorePages())
                    <a class="page-link" href="{{ $panti->appends(request()->input())->nextPageUrl() }}" rel="next">Next »</a>
                    @else
                    <span class="page-link">Next »</span>
                    @endif
                </li>
            </ul>
        </nav>
    </div>
    @endif
@else
Empty
@endif