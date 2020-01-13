@extends('layouts.dashboard', [
    'wsecond_title' => 'Category - Edit',
    'menu' => 'post',
    'sub_menu' => 'category',
    'alert' => [
        'action' => Session::get('action') ?? null,
        'message' => Session::get('message') ?? null
    ],
    'content_header' => [
        'title' => 'Category - Edit',
        'desc' => null,
        'breadcrumb' => [
            [
                'url' => route('dashboard.index'),
                'text' => 'Dashboard',
                'active' => false
            ], [
                'url' => route('dashboard.category.index'),
                'text' => 'Category',
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
<form class="card" action="{{ route('dashboard.category.update', $category->category_slug) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="card-header card-primary card-outline">
        <h1 class="card-title">Edit Category</h1>
        <div class="card-tools">
            <a href="{{ route('dashboard.category.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-chevron-circle-left"></i> Back
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="form-group" id="form-category_title">
            <label for="field-category_title">Title{!! printRequired() !!}</label>
            <input type="text" name="category_title" id="field-category_title" class="form-control @error('category_title') is-invalid @enderror" placeholder="Category Title" value="{{ $category->category_title }}" onkeyup="generateSlug('field-category_title', 'field-category_slug')">
            
            @error('category_title')
            <div class='invalid-feedback'>{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group" id="form-category_slug">
            <label for="field-category_slug">Slug{!! printRequired() !!}</label>
            <input type="text" name="category_slug" id="field-category_slug" class="form-control @error('category_slug') is-invalid @enderror" placeholder="Category Slug" value="{{ $category->category_slug }}">
            
            @error('category_slug')
            <div class='invalid-feedback'>{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group" id="form-category_description">
            <label for="field-category_description">Short Description</label>
            <textarea name="category_description" id="field-category_description" class="form-control @error('category_description') is-invalid @enderror" placeholder="Category Short Description">{{ $category->category_description }}</textarea>
            
            @error('category_description')
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