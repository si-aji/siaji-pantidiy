@extends('layouts.dashboard', [
    'wsecond_title' => 'Keyword - Detail',
    'menu' => 'post',
    'sub_menu' => 'keyword',
    'alert' => [
        'action' => Session::get('action') ?? null,
        'message' => Session::get('message') ?? null
    ],
    'content_header' => [
        'title' => 'Keyword - Detail',
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
                'text' => 'Detail',
                'active' => true
            ]
        ]
    ]
])

@section('content')
<div class="card">
    <div class="card-header card-primary card-outline">
        <h1 class="card-title">Detail {{ $keyword->keyword_title }}</h1>
        <div class="card-tools">
            <a href="{{ route('dashboard.keyword.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-chevron-circle-left"></i> Back
            </a>
            <a href="{{ route('dashboard.keyword.edit', $keyword->keyword_slug) }}" class="btn btn-warning btn-sm">
                <i class="far fa-edit"></i> Edit
            </a>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-hover table-striped">
            <tr>
                <th width="30%">Title</th>
                <td>{{ $keyword->keyword_title }}</td>
            </tr>
        </table>
    </div>
</div>
@endsection