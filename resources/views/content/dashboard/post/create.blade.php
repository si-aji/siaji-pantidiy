@extends('layouts.dashboard', [
    'wsecond_title' => 'Posts - Create',
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
                'active' => false
            ], [
                'url' => '#',
                'text' => 'Create',
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
<!-- Select2 -->
<link rel="stylesheet" href="{{ mix('adminlte/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ mix('adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection

@section('content')
<form class="card" action="{{ route('dashboard.post.store') }}" method="POST">
    @csrf
    <input type="hidden" name="author_id" value="{{ auth()->user()->id }}" readonly>

    <div class="card-header card-primary card-outline">
        <h1 class="card-title">Add new Posts</h1>
        <div class="card-tools">
            <a href="{{ route('dashboard.post.index') }}" class="btn btn-secondary btn-sm">
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
                                <label for="field-post_slug">URL Slug{!! printRequired() !!}</label>
                                <input type="text" name="post_slug" id="field-post_slug" class="form-control form-control-sm @error('post_slug') is-invalid @enderror" placeholder="URL Slug" onkeyup="slug_preview('field-post_slug', 'field-slug_preview');" value="{{ old('post_slug') }}">
                                
                                @error('post_slug')
                                <div class='invalid-feedback'>{{ $message }}</div>
                                @enderror
                            </div>

                            <p class="mb-0">Preview</p>
                            <small>
                                <a href="javascrit:void(0)" class="text-muted">{{ url('/').(old('post_slug') ? '/'.old('post_slug') : '') }}/<span class="mb-0" id="field-slug_preview"></span></a>
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
                                <label for="field-post_status">Status{!! printRequired() !!}</label>
                                <select name="post_status" id="field-post_status" class="form-control form-control-sm @error('post_status') is-invalid @enderror" onchange="checkStatus()">
                                    <option value="draft" {{ old('post_status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                    <option value="published" {{ old('post_status') == 'published' ? 'selected' : '' }}>Published</option>
                                </select>
                                
                                @error('post_status')
                                <div class='invalid-feedback'>{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input" type="checkbox" name="post_immediately" value="true" id="post_immediately" onchange="checkImmediately();" {{ old('post_immediately') == 'true' ? 'checked' : '' }}>
                                    <label for="post_immediately" class="custom-control-label">Publish Immediately</label>
                                </div>
                            </div>

                            <div class="form-group" id="form-post_published" style="{{ old('post_immediately') == 'true' ? 'display:none;' : (old('post_status') == 'draft' ? 'display:none' : '') }}">
                                <label>Date Published{!! printRequired('**', 'Date Published is Required if Status is Published and Publish Immediately not checked') !!}</label>
                                <input type="text" name="post_published" id="field-post_published" class="form-control @error('post_published') is-invalid @enderror datetimepicker-input" data-toggle="datetimepicker" data-target="#field-post_published">
        
                                @error('post_published')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card card-primary">
                    <div class="card-header">
                        <h4 class="card-title">
                            Category etc
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group" id="form-category_id">
                            <label>Category</label>
                            <select class="form-control select2 @error('category_id') is-invalid @enderror" name="category_id" id="field-category_id">
                                <option value="null" {{ old('category_id') == 'null' ? 'selected' : '' }}>- Select a Category -</option>
                                @foreach ($category as $item)
                                <option value="{{ $item->id }}" {{ old('category_id') == $item->id ? 'selected' : '' }}>{{ $item->category_title }}</option>
                                @endforeach
                            </select>

                            @error('category_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" name="post_shareable" value="true" id="post_shareable" {{ old('post_shareable') == 'true' ? 'checked' : '' }}>
                                <label for="post_shareable" class="custom-control-label">Allow Share</label>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" name="post_commentable" value="true" id="post_commentable" {{ old('post_commentable') == 'true' ? 'checked' : '' }}>
                                <label for="post_commentable" class="custom-control-label">Allow Comment</label>
                            </div>
                        </div>
                    </div>
                </div>{{-- Accordion --}}
            </div>
            <div class="col-12 col-lg-9">
                <div class="form-group">
                    <label for="field-post_title">Title{!! printRequired() !!}</label>
                    <input type="text" name="post_title" id="field-post_title" class="form-control @error('post_title') is-invalid @enderror" placeholder="Post Title" onkeyup="generateSlug('field-post_title', 'field-post_slug');slug_preview('field-post_title', 'field-slug_preview')" value="{{ old('post_title') }}">
                    
                    @error('post_title')
                    <div class='invalid-feedback'>{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <textarea name="post_content" id="field-post_content" class="form-control @error('post_content') is-invalid @enderror">{!! old('post_content') !!}</textarea>
                    
                    @error('post_content')
                    <div class='invalid-feedback'>{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group" id="form-keyword_id">
                    <label>Keyword</label>
                    <div class="input-group">
                        <select class="form-control @error('keyword_id') is-invalid @enderror" name="keyword_id[]" id="field-keyword_id" multiple="multiple">
                        </select>

                        <div class="input-group-append">
                            <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#modal-keyword"><i class="fas fa-plus"></i></button>
                        </div>
                    </div>
                    <small class="text-muted">Type "." (dot without quote) to show all stored keyword.</small>

                    @error('keyword_id')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
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

@section('content_modal')
{{-- Password Modal --}}
<form class="modal fade" tabindex="-1" role="dialog" id="modal-keyword">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add new Keyword</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group" id="field-keyword_title">
                    <label for="field-keyword_title">Title</label>
                    <input type="text" name="keyword_title" id="keyword_title" class="form-control @error('keyword_title') is-invalid @enderror" placeholder="Keyword Title" value="{{ old('keyword_title') }}" onkeyup="generateSlug('keyword_title', 'keyword_slug')">
                    
                    @error('keyword_title')
                    <div class='invalid-feedback'>{{ $message }}</div>
                    @enderror
                </div>
        
                <div class="form-group" id="field-keyword_slug">
                    <label for="field-keyword_title">Slug</label>
                    <input type="text" name="keyword_slug" id="keyword_slug" class="form-control @error('keyword_slug') is-invalid @enderror" placeholder="Keyword Slug" value="{{ old('keyword_slug') }}">
                    
                    @error('keyword_slug')
                    <div class='invalid-feedback'>{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="modal-footer br">
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                <button type="reset" class="btn btn-sm btn-danger" id="modal-keyword_reset" onclick="removeInvalid('modal-keyword')">Reset</button>
                <button type="submit" class="btn btn-sm btn-primary" id="modal-keyword_submit" onclick="removeInvalid('modal-keyword')">Submit</button>
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
<!-- Select2 -->
<script src="{{ mix('adminlte/plugins/select2/js/select2.full.min.js') }}"></script>
@endsection

@section('inline_js')
<script>
    $(document).ready(function(){
        $('.select2').select2();
        $("#field-keyword_id").select2({
            placeholder: 'Search for a keyword',
            minimumInputLength: 1,
            allowClear: true,
            ajax: {
                url: "{{ route('dashboard.select2.keyword.select2') }}",
                delay: 250,
                data: function (params) {
                    var query = {
                        search: params.term,
                        page: params.page || 1
                    }

                    // Query parameters will be ?search=[term]&type=public
                    return query;
                },
                processResults: function (data, params) {
                    var items = $.map(data.data, function(obj){
                        obj.id = obj.id;
                        obj.text = obj.keyword_title;

                        return obj;
                    });
                    params.page = params.page || 1;

                    // console.log(items);
                    // Transforms the top-level key of the response object from 'items' to 'results'
                    return {
                        results: items,
                        pagination: {
                            more: params.page < data.last_page
                        }
                    };
                },
            },
            templateResult: function (item) {
                // console.log(item);
                // No need to template the searching text
                if (item.loading) {
                    return item.text;
                }
                
                var term = select2_query.term || '';
                var $result = markMatch(item.text, term);

                return $result;
            },
            language: {
                searching: function (params) {
                    // Intercept the query as it is happening
                    select2_query = params;
                    
                    // Change this to be appropriate for your application
                    return 'Searching...';
                }
            }
        });

        $("#field-post_content").summernote({
            'height': 350,
            'placeholder': 'Start writing or type...',
        });

        checkStatus();
    });

    $('#field-post_published').datetimepicker({
        useCurrent: false,
        format: "YYYY-MM-DD H:mm:ss",
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
        let check_immediately = $("#post_immediately").is(':checked');
        let post_status = $("#field-post_status");
        if(check_immediately){
            post_status.val('published').change();
        } else {
            post_status.val('draft').change();
        }
    }

    function checkStatus(){
        let post_status = $("#field-post_status").val();
        let check_immediately = $("#post_immediately").is(':checked');

        if(post_status == 'published' && !(check_immediately)){
            $("#form-post_published").slideDown();
            $('#field-post_published').datetimepicker('enable');
        } else {
            $("#form-post_published").slideUp();
            $('#field-post_published').datetimepicker('disable');
        }
    }

    $("#modal-keyword").submit(function(e){
        e.preventDefault();
        console.log("Keyword Form is being submited");
        $("#modal-keyword_reset").attr('disabled', true);
        $("#modal-keyword_submit").attr('disabled', true);

        // Form Data
        let form_data = $(e.target).serialize();
        $.post("{{ route('dashboard.keyword.store') }}", form_data, function(result){
            console.log(result);

            var data = result.data;
            var select_option = {
                id: data.id,
                text: data.keyword_title
            };
            var newOption = new Option(select_option.text, select_option.id, true, true);

            console.log(select_option);
            $('#field-keyword_id').append(newOption).trigger('change');

            $("#modal-keyword").modal('hide');
        }).always(function(result){
            $("#modal-keyword_reset").attr('disabled', false);
            $("#modal-keyword_submit").attr('disabled', false);
        }).fail(function(jqXHR, textStatus, errorThrown){
            console.log("Ajax Fail");
            console.log(jqXHR);
            $.each(jqXHR.responseJSON.errors, function(key, result){
                $("#"+key).addClass('is-invalid');
                $("#field-"+key).append("<div class='invalid-feedback'>"+result+"</div>");
            });
        });
    });

    $("#modal-keyword").on('hide.bs.modal', function(){
        console.log("Modal is being hide");
        $("#modal-keyword_reset").click();
    });
</script>
@endsection