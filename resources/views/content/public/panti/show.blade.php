@extends('layouts.public', [
    'wsecond_title' => 'List Panti'
])

@section('plugins_css')
<!-- Select2 -->
<link rel="stylesheet" href="{{ mix('adminlte/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ mix('fancy/css/others/select2/select2.css') }}">
<link rel="stylesheet" href="{{ mix('adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection

@section('content')
@include('layouts.partials.public.content-header', [
    'page_title' => 'Detail Panti',
    'breadcrumb' => [
        [
            'breadcrumb_title' => 'Panti',
            'is_active' => false,
            'url' => route('public.panti'),
            'breadcrumb_icon' => null
        ], [
            'breadcrumb_title' => $panti->panti_name,
            'is_active' => true,
            'url' => null,
            'breadcrumb_icon' => null
        ]
    ]
])

<section class="section-padding-100 container" id="panti_detail-area">
    <div class="row">
        <div class="col-12 col-md-8">
            <div class="fancy-paginate">
                <ul class="nav">
                    <li {!! empty($prev) ? 'class="disabled"' : '' !!}>
                        @if(!empty($prev))
                        <a href="{{ route('public.panti.show', $prev->panti_slug) }}">
                            <i class="fa fa-arrow-left" aria-hidden="true"></i>
                        </a>
                        @else
                        <i class="fa fa-arrow-left" aria-hidden="true"></i>
                        @endif
                    </li>
                    <li {!! empty($next) ? 'class="disabled"' : '' !!}>
                        @if(!empty($next))
                        <a href="{{ route('public.panti.show', $next->panti_slug) }}">
                            <i class="fa fa-arrow-right" aria-hidden="true"></i>
                        </a>
                        @else
                        <i class="fa fa-arrow-right" aria-hidden="true"></i>
                        @endif
                    </li>
                </ul>
            </div>
            <div class="section-heading">
                <h2>{{ $panti->panti_name }}</h2>
            </div>
            <div class="section-body">
                {!! $panti->panti_description !!}
            </div>
        </div>

        <div class="col-12 col-md-4">
            <div class="panti-information">
                <p class="info-title">Provinsi</p>
                <p>{{ $panti->provinsi()->exists() ? $panti->provinsi->provinsi_name : '-' }}</p>
            </div>

            <div class="panti-information">
                <p class="info-title">Kabupaten</p>
                <p>{{ $panti->kabupaten()->exists() ? $panti->kabupaten->kabupaten_name : '-' }}</p>
            </div>

            <div class="panti-information">
                <p class="info-title">Kecamatan</p>
                <p>{{ $panti->kecamatan()->exists() ? $panti->kecamatan->kecamatan_name : '-' }}</p>
            </div>
        </div>
    </div>
</section>
@endsection