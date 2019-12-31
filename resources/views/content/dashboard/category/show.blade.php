@extends('layouts.dashboard', [
    'wsecond_title' => 'Category - Detail',
    'menu' => 'post',
    'sub_menu' => 'category',
    'alert' => [
        'action' => Session::get('action') ?? null,
        'message' => Session::get('message') ?? null
    ],
    'content_header' => [
        'title' => 'Category - Detail',
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
                'text' => 'Detail',
                'active' => true
            ]
        ]
    ]
])

@section('content')
<div class="card">
    <div class="card-header card-primary card-outline">
        <h1 class="card-title">Detail {{ $category->category_title }}</h1>
        <div class="card-tools">
            <a href="{{ route('dashboard.category.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-chevron-circle-left"></i> Back
            </a>
            <a href="{{ route('dashboard.category.edit', $category->category_slug) }}" class="btn btn-warning btn-sm">
                <i class="far fa-edit"></i> Edit
            </a>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-hover table-striped">
            <tr>
                <th width="30%">Title</th>
                <td>{{ $category->category_title }}</td>
            </tr>
            <tr>
                <th>Short Description</th>
                <td>{{ $category->category_description }}</td>
            </tr>
        </table>
    </div>
</div>
@endsection