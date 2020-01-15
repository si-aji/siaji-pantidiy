<div class="fancy-breadcumb-area bg-img bg-overlay" style="background-image: url({{ asset('fancy/img/bg-img/hero-1.jpg') }});">
    <div class="container h-100">
        <div class="row h-100 align-items-center">
            <div class="col-12">
                <div class="breadcumb-content text-center">
                    <h2>{{ $page_title }}</h2>
                    <!-- Breadcumb -->
                    <nav>
                        <ol class="breadcrumb justify-content-center">
                            <li class="breadcrumb-item">
                                <a href="{{ route('public.index') }}">
                                    <i class="fa fa-home" aria-hidden="true"></i> Home
                                </a>
                            </li>
                            @foreach($breadcrumb as $item)
                            <li class="breadcrumb-item {{ $item['is_active'] ? 'active' : '' }}">
                                @if($item['is_active'])
                                    @if($item['breadcrumb_icon'])
                                <i class="fa fa-{{ $item['breadcrumb_icon'] }}" aria-hidden="true"></i>
                                    @endif
                                {{ $item['breadcrumb_title'] }}
                                @else
                                <a href="{{ $item['url'] ?? '#' }}">
                                    @if($item['breadcrumb_icon'])
                                    <i class="fa fa-{{ $item['breadcrumb_icon'] }}" aria-hidden="true"></i>
                                    @endif
                                    {{ $item['breadcrumb_title'] }}
                                </a>
                                @endif
                            </li>
                            @endforeach
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>