@extends('layouts.dashboard', [
    'wsecond_title' => 'Keyword - Edit',
    'menu' => 'post',
    'sub_menu' => 'keyword',
    'alert' => [
        'action' => Session::get('action') ?? null,
        'message' => Session::get('message') ?? null
    ],
    'content_header' => [
        'title' => 'Keyword - Edit',
        'desc' => null,
        'breadcrumb' => [
            [
                'url' => route('dashboard.index'),
                'text' => 'Dashboard',
                'active' => false
            ], [
                'url' => route('dashboard.keyword.index'),
                'text' => 'Keyword',
                'active' => false
            ], [
                'url' => '#',
                'text' => 'Edit',
                'active' => true
            ]
        ]
    ]
])

@section('content')
<form class="card" action="{{ route('dashboard.keyword.update', $keyword->keyword_slug) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="card-header card-primary card-outline">
        <h1 class="card-title">Edit Keyword</h1>
        <div class="card-tools">
            <a href="{{ route('dashboard.keyword.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-chevron-circle-left"></i> Back
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="form-group">
            <label for="field-keyword_title">Title</label>
            <input type="text" name="keyword_title" id="field-keyword_title" class="form-control @error('keyword_title') is-invalid @enderror" placeholder="Keyword Title" value="{{ $keyword->keyword_title }}" onkeyup="generateSlug('field-keyword_title', 'field-keyword_slug')">
            
            @error('keyword_title')
            <div class='invalid-feedback'>{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="field-keyword_title">Slug</label>
            <input type="text" name="keyword_slug" id="field-keyword_slug" class="form-control @error('keyword_slug') is-invalid @enderror" placeholder="Keyword Slug" value="{{ $keyword->keyword_slug }}">
            
            @error('keyword_slug')
            <div class='invalid-feedback'>{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group row">
            <div class="offset-sm-2 col-sm-10 text-right text-md-right">
                <button type="reset" id="btn-field_reset" class="btn btn-sm btn-danger">Reset</button>
                <button type="submit" class="btn btn-sm btn-primary">Submit</button>
            </div>
        </div>
    </div>
</form>
@endsection

@section('plugins_js')
<script src="{{ mix('adminlte/js/siaji.js') }}"></script>
@endsection