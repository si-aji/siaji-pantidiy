@extends('layouts.dashboard', [
    'wsecond_title' => 'Liputan Panti - Edit',
    'menu' => 'panti',
    'sub_menu' => 'liputan',
    'alert' => [
        'action' => Session::get('action') ?? null,
        'message' => Session::get('message') ?? null
    ],
    'content_header' => [
        'title' => 'Liputan Panti - Edit',
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
<form class="card" action="{{ route('dashboard.panti.liputan.update', $liputan->id) }}" method="POST" id="liputan-form">
    @csrf
    @method('PUT')

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

        <div class="card">
            <div class="card-header card-primary card-outline">
                <h6 class="card-title">Liputan</h6>
            </div>
            <div class="card-body">
                <input type="hidden" name="panti_id" value="{{ $panti->id }}" readonly>
                <input type="hidden" name="author_id" value="{{ auth()->user()->id }}" readonly>
                
                <div class="form-group">
                    <label for="liputan_date">Tanggal Liputan{!! printRequired() !!}</label>
                    <input type="text" name="liputan_date" id="liputan_date" class="form-control @error('liputan_date') is-invalid @enderror datetimepicker-input" data-toggle="datetimepicker" data-target="#liputan_date" placeholder="Tanggal Liputan">
            
                    @error('liputan_date')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="form-group">
                    <textarea id="liputan_content" name="liputan_content" class="liputan_content @error('liputan_content') is-invalid @enderror">{!! $liputan->liputan_content !!}</textarea>
        
                    @error('liputan_content')
                        <small class="text-danger">
                            <span>{{ $message }}</span>
                        </small>
                    @enderror
                </div>

                <div class="form-group row">
                    <div class="offset-sm-2 col-sm-10 text-right text-md-right">
                        <button type="reset" id="btn-field_reset" class="btn btn-sm btn-danger">Reset</button>
                        @if(auth()->user()->id != $liputan->author_id)
                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-confirmation">
                            <i class="fas fa-lock"></i> Submit
                        </button>
                        @else
                        <button type="submit" class="btn btn-sm btn-primary">Submit</button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@if(auth()->user()->id != $liputan->author_id)
@section('content_modal')
{{-- Confirmation Modal --}}
<form class="modal fade" tabindex="-1" role="dialog" id="modal-confirmation">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Permission Confirmation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>You are not the real author, please tick checkbox below</p>

                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input" type="checkbox" id="confirm_checkbox" name="confirm_checkbox" value="understand" required>
                    <label for="confirm_checkbox" class="custom-control-label">Sure, I'm understand</label>
                </div>
            </div>
            <div class="modal-footer br">
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                <button type="reset" class="btn btn-sm btn-danger" id="confirmation-reset" onclick="removeInvalid()">Reset</button>
                <button type="submit" class="btn btn-sm btn-primary" id="confirmation-submit" onclick="removeInvalid()">Save changes</button>
            </div>
        </div>
    </div>
</form>
@endsection
@endif

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
        $("#liputan_content").summernote({
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

    $('#liputan_date').datetimepicker({
        useCurrent: false,
        format: "YYYY-MM-DD",
        defaultDate: "{{ $liputan->liputan_date ? $liputan->liputan_date : date('Y-m-d') }}",
        maxDate: "{{ date('Y-m-d') }}"
    });

    $("#modal-confirmation").submit(function(e){
        e.preventDefault();

        $("#liputan-form").submit();
    });
</script>
@endsection