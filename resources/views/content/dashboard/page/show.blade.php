@extends('layouts.dashboard', [
    'wsecond_title' => 'Pages - Detail',
    'menu' => 'page',
    'sub_menu' => null,
    'alert' => [
        'action' => Session::get('action') ?? null,
        'message' => Session::get('message') ?? null
    ],
    'content_header' => [
        'title' => 'Pages',
        'desc' => null,
        'breadcrumb' => [
            [
                'url' => route('dashboard.index'),
                'text' => 'Dashboard',
                'active' => false
            ], [
                'url' => route('dashboard.page.index'),
                'text' => 'Pages',
                'active' => true
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
        <h1 class="card-title">Detail {{ $page->page_title }}</h1>
        <div class="card-tools">
            <a href="{{ route('dashboard.page.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-chevron-circle-left"></i> Back
            </a>
            <a href="{{ route('dashboard.page.edit', $page->page_slug) }}" class="btn btn-warning btn-sm">
                <i class="far fa-edit"></i> Edit
            </a>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-hover table-striped">
            <tr>
                <th width="30%">Title</th>
                <td>{{ $page->page_title }}</td>
            </tr>
            <tr>
                <th>Slug</th>
                <td>{{ url('/').'/'.$page->page_slug }}</td>
            </tr>
            <tr>
                <th>Status</th>
                <td>{{ $page->page_status == 'published' ? ($page->page_published > date('Y-m-d H:i:s') ? 'Scheduled - '.date('M d o, H:i:s', strtotime($page->page_published)) : ucwords($page->page_status).' - '.date('M d o, H:i:s', strtotime($page->page_published))) : ucwords($page->page_status) }}</td>
            </tr>
            <tr>
                <th>Thumbnail</th>
                <td>
                    @if(!empty($page->page_thumbnail))
                    <div class="sa-preview mb-2">
                        <img class="img-responsive img-preview" src="{{ asset('img/page'.'/'.$page->page_thumbnail) }}">
                    </div>
                    @else
                    -
                    @endif
                </td>
            </tr>
            <tr>
                <th>Content</th>
                <td>
                    {!! $page->page_content !!}
                </td>
            </tr>
        </table>
    </div>
</div>
@endsection