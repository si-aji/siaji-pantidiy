@extends('layouts.dashboard', [
    'wsecond_title' => 'Pages - Edit',
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
                'active' => false
            ], [
                'url' => '#',
                'text' => 'Edit',
                'active' => true
            ]
        ]
    ]
])

@section('plugins_css')
<!-- Summernote -->
<link rel="stylesheet" href="{{ mix('adminlte/plugins/summernote/summernote-bs4.css') }}">
<!-- Tempus Dominus -->
<link rel="stylesheet" href="{{ mix('adminlte/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.css') }}">
@endsection

@section('content')
<form class="card" action="{{ route('dashboard.page.update', $page->page_slug) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="card-header card-primary card-outline">
        <h1 class="card-title">Edit Pages</h1>
        <div class="card-tools">
            <a href="{{ route('dashboard.page.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-chevron-circle-left"></i> Back
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12 col-lg-3">
                {{-- Accordion --}}
                <div id="accordion">
                    <!-- we are adding the .class so bootstrap.js collapse plugin detects it -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h4 class="card-title">
                                Permalink
                            </h4>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="field-page_slug">URL Slug</label>
                                <input type="text" name="page_slug" id="field-page_slug" class="form-control form-control-sm @error('page_slug') is-invalid @enderror" placeholder="URL Slug" onkeyup="slug_preview('field-page_slug', 'field-slug_preview');" value="{{ $page->page_slug }}">
                                
                                @error('page_slug')
                                <div class='invalid-feedback'>{{ $message }}</div>
                                @enderror
                            </div>

                            <p class="mb-0">Preview</p>
                            <small>
                                <a href="javascrit:void(0)" class="text-muted">{{ url('/').'/'.$page->page_slug }}/<span class="mb-0" id="field-slug_preview"></span></a>
                            </small>
                        </div>
                    </div>

                    <div class="card card-primary">
                        <div class="card-header">
                            <h4 class="card-title">
                                Status & Date Setting
                            </h4>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="field-page_status">Status</label>
                                <select name="page_status" id="field-page_status" class="form-control form-control-sm @error('page_status') is-invalid @enderror" onchange="checkStatus()">
                                    <option value="draft" {{ $page->page_status == 'draft' ? 'selected' : '' }}>Draft</option>
                                    <option value="published" {{ $page->page_status == 'published' ? 'selected' : '' }}>Published</option>
                                </select>
                                
                                @error('page_status')
                                <div class='invalid-feedback'>{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input" type="checkbox" name="page_immediately" value="true" id="page_immediately" onchange="checkImmediately();" {{ old('page_immediately') == 'true' ? 'checked' : '' }}>
                                    <label for="page_immediately" class="custom-control-label">Publish Immediately</label>
                                </div>
                            </div>

                            <div class="form-group" id="form-page_published" style="{{ $page->page_status == 'draft' ? 'display:none' : '' }}">
                                <label>Date Published</label>
                                <input type="text" name="page_published" id="field-page_published" class="form-control @error('page_published') is-invalid @enderror datetimepicker-input" data-toggle="datetimepicker" data-target="#field-page_published">
        
                                @error('page_published')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>{{-- Accordion --}}
            </div>
            <div class="col-12 col-lg-9">
                <div class="form-group">
                    <label for="field-page_title">Title</label>
                    <input type="text" name="page_title" id="field-page_title" class="form-control @error('page_title') is-invalid @enderror" placeholder="Page Title" onkeyup="generateSlug('field-page_title', 'field-page_slug');slug_preview('field-page_title', 'field-slug_preview')" value="{{ $page->page_title }}">
                    
                    @error('page_title')
                    <div class='invalid-feedback'>{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <textarea name="page_content" id="field-page_content" class="form-control @error('page_content') is-invalid @enderror">{!! $page->page_content !!}</textarea>
                    
                    @error('page_content')
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
        </div>
    </div>
</form>
@endsection

@section('plugins_js')
<script src="{{ mix('adminlte/js/siaji.js') }}"></script>
<!-- Summernote -->
<script src="{{ mix('adminlte/plugins/summernote/summernote-bs4.min.js') }}"></script>
<!-- Tempus Dominus -->
<script src="{{ mix('adminlte/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.js') }}"></script>
@endsection

@section('inline_js')
<script>
    $(document).ready(function(){
        $("#field-page_content").summernote({
            'height': 300,
            'placeholder': 'Start writing or type...',
        });

        checkStatus();
    });

    $('#field-page_published').datetimepicker({
        useCurrent: false,
        format: "YYYY-MM-DD H:mm:ss",
        {!! $page->page_status == 'published' ? 'defaultDate: "'.$page->page_published.'"' : '' !!}
    });

    function slug_preview(source, target){
        console.log("Slug Preview is running...");
        console.log("Source : "+source+" / Target : "+target);

        var title = $("#"+source).val();
        var slug = title
            .toLowerCase()
            .replace(/[^\w ]+/g,'')
            .replace(/ +/g,'-');
        if(slug.slice(-1) == "-"){
            slug = slug.slice(0, -1);
        }
        
        $("#"+target).text(slug);
    }

    function checkImmediately(){
        let check_immediately = $("#page_immediately").is(':checked');
        let page_status = $("#field-page_status");
        if(check_immediately){
            page_status.val('published').change();
        } else {
            page_status.val('{{ $page->page_status }}').change();
        }
    }

    function checkStatus(){
        let page_status = $("#field-page_status").val();
        let check_immediately = $("#page_immediately").is(':checked');

        if(page_status == 'published' && !(check_immediately)){
            $("#form-page_published").slideDown();
            $('#field-page_published').datetimepicker('enable');
        } else {
            $("#form-page_published").slideUp();
            $('#field-page_published').datetimepicker('disable');
        }
    }
</script>
@endsection