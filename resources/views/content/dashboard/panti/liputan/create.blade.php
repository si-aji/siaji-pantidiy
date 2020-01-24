@extends('layouts.dashboard', [
    'wsecond_title' => 'Liputan Panti - Create',
    'menu' => 'panti',
    'sub_menu' => 'liputan',
    'alert' => [
        'action' => Session::get('action') ?? null,
        'message' => Session::get('message') ?? null
    ],
    'content_header' => [
        'title' => 'Liputan Panti - Create',
        'desc' => null,
        'breadcrumb' => [
            [
                'url' => route('dashboard.index'),
                'text' => 'Dashboard',
                'active' => false
            ], [
                'url' => route('dashboard.panti.index'),
                'text' => 'Liputan',
                'active' => false
            ], [
                'url' => route('dashboard.panti.show', $panti->panti_slug),
                'text' => 'Panti '.$panti->panti_name,
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
@endsection

@section('content')
<form class="card" action="{{ route('dashboard.panti.liputan.store', $panti->panti_slug) }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="card-header card-secondary card-outline">
        <h1 class="card-title">Liputan {{ $panti->panti_name }}</h1>
        <div class="card-tools">
            <a href="{{ route('dashboard.panti.show', $panti->panti_slug) }}" class="btn btn-primary btn-sm">
                <i class="fas fa-eye"></i> Detail
            </a>
            <a href="{{ route('dashboard.panti.edit', $panti->panti_slug) }}" class="btn btn-warning btn-sm">
                <i class="fas fa-edit"></i> Edit
            </a>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-hover table-striped mb-4">
            <tr>
                <th width="30%">Name</th>
                <td>{{ $panti->panti_name }}</td>
            </tr>
            <tr>
                <th>Alamat</th>
                <td>{{ $panti->panti_alamat }}</td>
            </tr>
            <tr>
                <th>Provinsi</th>
                <td>{{ !empty($panti->provinsi_id) ? $panti->provinsi->provinsi_name : '-' }}</td>
            </tr>
            <tr>
                <th>Kabupaten</th>
                <td>{{ !empty($panti->kabupaten_id) ? $panti->kabupaten->kabupaten_name : '-' }}</td>
            </tr>
            <tr>
                <th>Kecamatan</th>
                <td>{{ !empty($panti->kecamatan_id) ? $panti->kecamatan->kecamatan_name : '-' }}</td>
            </tr>
        </table>

        <div class="card" id="form-panti_gallery">
            <div class="card-header card-primary card-outline">
                <h1 class="card-title">Liputan Gallery</h1>
                <div class="card-tools">
                    <button type="button" class="btn btn-primary btn-xs" id="panti-gallery_add">
                        <i class="fas fa-plus"></i> Add
                    </button>
                </div>
            </div>
            @if(old('gallery'))
                @php $gallery_start = 0; @endphp
            <div class="card-body">
                <div class="row" id="panti-body">
                    @foreach(old('gallery') as $key => $value)
                    <div class="panti-gallery_item col-12 col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group" id="form-panti_image_{{ $gallery_start }}">
                                    <div class="sa-preview mb-2">
                                        <button type="button" class="btn btn-sm btn-danger d-block mb-2 mx-auto btn-preview_remove" onclick="removePreview($(this), '', 'panti_image_{{ $gallery_start }}')" disabled>Reset Preview</button>
                                        <img class="img-responsive img-preview">
                                    </div>
    
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input @error('gallery.'.$key.'.file') is-invalid @enderror" name="gallery[{{ $gallery_start }}][file]" id="customFile_{{ $gallery_start }}" onchange="generatePreview($(this), 'panti_image_{{ $gallery_start }}')">
                                        <label class="custom-file-label" for="customFile">Choose file</label>
                                    
                                        @error('gallery.'.$key.'.file')
                                        <div class='invalid-feedback'>{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer clearfix">
                                <button type="button" class="btn btn-warning btn-sm float-right gallery-remove"><i class="fas fa-times"></i> Remove item</button>
                            </div>
                        </div>
                    </div>
                        @php $gallery_start++; @endphp
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        <div class="card">
            <div class="card-header card-primary card-outline">
                <h6 class="card-title">Liputan</h6>
            </div>
            <div class="card-body">
                <input type="hidden" name="panti_id" value="{{ $panti->id }}" readonly>
                <input type="hidden" name="author_id" value="{{ auth()->user()->id }}" readonly>
                
                <div class="form-group" id="form-liputan_date">
                    <label for="liputan_date">Tanggal Liputan{!! printRequired() !!}</label>
                    <input type="text" name="liputan_date" id="field-liputan_date" class="form-control @error('liputan_date') is-invalid @enderror datetimepicker-input" data-toggle="datetimepicker" data-target="#field-liputan_date" placeholder="Tanggal Liputan">
            
                    @error('liputan_date')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group" id="form-liputan_content">
                    <textarea id="field-liputan_content" name="liputan_content" class="liputan_content @error('liputan_content') is-invalid @enderror">{!! old('liputan_content') !!}</textarea>
        
                    @error('liputan_content')
                        <small class="text-danger">
                            <span>{{ $message }}</span>
                        </small>
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
<!-- bs-custom-file-input -->
<script src="{{ mix('adminlte/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
@endsection

@section('inline_js')
<script>
    $(document).ready(function(){
        bsCustomFileInput.init();
        // Add more Gallery
        let gallery_start = {{ old('gallery') ? $gallery_start : '0' }};
        let gallery_wrap = $("#form-panti_gallery");
        let gallery_add = $("#panti-gallery_add");
        let gallery_file = 'gallery_file';
        let gallery_length = {{ old('gallery') ? $gallery_start : '0' }};
        let gallery_fieldform = null;
        let gallery_null = "''";

        gallery_add.click(function(e){
            e.preventDefault();
            console.log("Gallery Add More is running...");
            gallery_fieldform = "'panti_image_"+gallery_start+"'";
            // console.log(gallery_fieldform);
            // console.log("start : "+gallery_start);

            if(gallery_length <= 0){
                $(
                    '<div class="card-body" style="display:none;"><div class="row" id="panti-body"></div></div>'
                ).appendTo(gallery_wrap).slideDown();
            }

            $(
                '<div class="panti-gallery_item col-12 col-lg-4" style="display:none">'
                    +'<div class="card">'
                        +'<div class="card-body">'
                            +'<div class="form-group mb-0" id="form-panti_image_'+gallery_start+'">'
                                +'<div class="sa-preview mb-2">'
                                    +'<button type="button" class="btn btn-sm btn-danger d-block mb-2 mx-auto btn-preview_remove" onclick="removePreview($(this), '+gallery_null+', '+gallery_fieldform+')" disabled>Reset Preview</button>'
                                    +'<img class="img-responsive img-preview">'
                                +'</div>'

                                +'<div class="custom-file">'
                                    +'<input type="hidden" name="gallery['+gallery_start+'][validate]" readonly>'
                                    +'<input type="file" class="custom-file-input" name="gallery['+gallery_start+'][file]" id="customFile_'+gallery_start+'" onchange="generatePreview($(this), '+gallery_fieldform+')">'
                                    +'<label class="custom-file-label" for="customFile">Choose file</label>'
                                +'</div>'
                            +'</div>'
                        +'</div>'
                        +'<div class="card-footer clearfix">'
                            +'<button type="button" class="btn btn-warning btn-sm float-right gallery-remove"><i class="fas fa-times"></i> Remove item</button>'
                        +'</div>'
                    +'</div>'
                +'</div>'
            ).appendTo('#panti-body').slideDown();

            // console.log("start After Append : "+gallery_start);

            gallery_length++;
            gallery_start++;
            console.log(gallery_length);
            checkIsthumb();
        });
        gallery_wrap.on('click','.gallery-remove', function(e){
            console.log("Panti Gallery is being removed via wrap");
            e.preventDefault();

            $(this).closest('.panti-gallery_item').slideUp(function(){
                $(this).remove();
                gallery_length--;

                setTimeout(function(){
                    if(gallery_length <= 0){
                        $('#form-panti_gallery .card-body').slideUp(function(){
                            $(this).remove();
                        })
                    }
                });
                console.log(gallery_length);
            });
        });

        $("#field-liputan_content").summernote({
            height: 200,
            placeholder: "Some text here...",
            toolbar: [
                ['style'],
                ['misc', ['codeview', 'undo', 'redo']],
                ['font_style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['fontsize', 'fontname', 'color']],
                ['para', ['ul', 'ol', 'paragraph', 'height']],
                ['insert', ['picture', 'link', 'video', 'table', 'hr']]
            ]
        });
    });

    $('#field-liputan_date').datetimepicker({
        useCurrent: false,
        format: "YYYY-MM-DD",
        defaultDate: "{{ old('liputan_date') ? old('liputan_date') : date('Y-m-d') }}",
        maxDate: "{{ date('Y-m-d') }}"
    });
</script>
@endsection