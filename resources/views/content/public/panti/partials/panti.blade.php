@if(!empty($panti))
    @foreach($panti as $value)
    <div class="panti-container d-sm-flex mb-4">
        <div class="panti-thumb">
            <img src="{{ asset('fancy/img/blog-img/blog-1.jpg') }}" alt="">
        </div>
        <div class="panti-content media-body">
            <div class="panti-title">
                {{ $value->panti_name }}
            </div>
            <div class="panti-subtitle">
                {{ $value->pantiLiputan()->count() }} Liputan
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
        {{ $panti->appends(request()->input())->links() }}
    </div>
    @endif
@else
Empty
@endif