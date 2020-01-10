@extends('layouts.dashboard', [
    'wsecond_title' => 'Posts - Detail',
    'menu' => 'post',
    'sub_menu' => 'post_list',
    'alert' => [
        'action' => Session::get('action') ?? null,
        'message' => Session::get('message') ?? null
    ],
    'content_header' => [
        'title' => 'Posts',
        'desc' => null,
        'breadcrumb' => [
            [
                'url' => route('dashboard.index'),
                'text' => 'Dashboard',
                'active' => false
            ], [
                'url' => route('dashboard.post.index'),
                'text' => 'Posts',
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
        <h1 class="card-title">Detail {{ $post->post_title }}</h1>
        <div class="card-tools">
            <a href="{{ route('dashboard.post.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-chevron-circle-left"></i> Back
            </a>
            <a href="{{ route('dashboard.post.edit', $post->post_slug) }}" class="btn btn-warning btn-sm">
                <i class="far fa-edit"></i> Edit
            </a>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-hover table-striped">
            <tr>
                <th width="30%">Category</th>
                <td>{{ !empty($post->category_id) ? $post->category->category_title : 'Uncategorized' }}</td>
            </tr>
            <tr>
                <th>Title</th>
                <td>{{ $post->post_title }}</td>
            </tr>
            <tr>
                <th>Slug</th>
                <td>{{ url('/').'/'.$post->post_slug }}</td>
            </tr>
            <tr>
                <th>Author</th>
                <td>{{ $post->author->name }}</td>
            </tr>
            @if(!empty($post->editor_id))
            <tr>
                <th>Editor</th>
                <td>{{ $post->editor->name }}</td>
            </tr>
            @endif
            <tr>
                <th>Status</th>
                <td>{{ $post->post_status == 'published' ? ($post->post_published > date('Y-m-d H:i:s') ? 'Scheduled - '.date('M d o, H:i:s', strtotime($post->post_published)) : ucwords($post->post_status).' - '.date('M d o, H:i:s', strtotime($post->post_published))) : ucwords($post->post_status) }}</td>
            </tr>
            <tr>
                <th>Content</th>
                <td>
                    {!! $post->post_content !!}
                </td>
            </tr>
            @if($post->keyword()->exists())
            <tr>
                <td>Keyword</td>
                <td>
                    @foreach($post->keyword as $keyword)
                    <a href="{{ route('dashboard.keyword.show', $keyword->keyword_slug) }}" class="badge badge-secondary p-2">{{ $keyword->keyword_title }}</a>
                    @endforeach
                </td>
            </tr>
            @endif
        </table>
    </div>
</div>
@endsection