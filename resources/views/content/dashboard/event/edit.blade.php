@extends('layouts.dashboard', [
    'wsecond_title' => 'Event - Edit',
    'menu' => 'event',
    'sub_menu' => null,
    'alert' => [
        'action' => Session::get('action') ?? null,
        'message' => Session::get('message') ?? null
    ],
    'content_header' => [
        'title' => 'Event',
        'desc' => null,
        'breadcrumb' => [
            [
                'url' => route('dashboard.index'),
                'text' => 'Dashboard',
                'active' => false
            ], [
                'url' => route('dashboard.event.index'),
                'text' => 'Event',
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
<!-- Select2 -->
<link rel="stylesheet" href="{{ mix('adminlte/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ mix('adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection

@section('content')
<form class="card" action="{{ route('dashboard.event.update', $event->event_slug) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="card-header card-primary card-outline">
        <h1 class="card-title">Edit Event</h1>
        <div class="card-tools">
            <a href="{{ route('dashboard.event.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-chevron-circle-left"></i> Back
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="form-group" id="form-event_title">
            <label for="field-event_title">Title{!! printRequired() !!}</label>
            <input type="text" name="event_title" id="field-event_title" class="form-control @error('event_title') is-invalid @enderror" placeholder="Event Title" onkeyup="generateSlug('field-event_title', 'field-event_slug')" value="{{ $event->event_title }}">
            @error('event_title')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group" id="form-event_slug">
            <label for="field-event_slug">Slug{!! printRequired() !!}</label>
            <input type="text" name="event_slug" id="field-event_slug" class="form-control @error('event_slug') is-invalid @enderror" placeholder="Event Slug" value="{{ $event->event_slug }}">
            @error('event_slug')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group" id="form-event_thumbnail">
            <label>Thumbnail</label>

            <div class="row">
                <div class="col-12 col-md-4">
                    <div class="sa-preview">
                        <button type="button" class="btn btn-sm btn-danger d-block mb-2 mx-auto btn-preview_remove" onclick="removePreview($(this),  '{{ asset('img/event'.'/'.$event->event_thumbnail) }}', 'event_thumbnail')" disabled>Reset Preview</button>
                        <img class="img-responsive img-preview" {{ !empty($event->event_thumbnail) ? 'src='.asset('img/event'.'/'.$event->event_thumbnail) : '' }}>
                    </div>
                </div>
                
                <div class="col-12 col-md-8">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" name="event_thumbnail" id="customFile" onchange="generatePreview($(this), 'event_thumbnail')">
                        <label class="custom-file-label" for="customFile">Choose file</label>
                    </div>
        
                    @error('event_thumbnail')
                    <div class='invalid-feedback'>{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="form-group" id="form-event_description">
            <label for="field-event_description">Description{!! printRequired() !!}</label>
            <textarea name="event_description" id="field-event_description" class="form-control @error('event_description') is-invalid @enderror">{!! $event->event_description !!}</textarea>
            
            @error('event_description')
            <div class='invalid-feedback'>{{ $message }}</div>
            @enderror
        </div>

        <div class="form-row">
            <div class="col-12 col-md-6 form-group" id="form-event_start">
                <label for="field-event_start">Start{!! printRequired() !!}</label>
                <input type="text" name="event_start" id="field-event_start" class="form-control @error('event_start') is-invalid @enderror datetimepicker-input" data-toggle="datetimepicker" data-target="#field-event_start">
                @error('event_start')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-12 col-md-6 form-group" id="form-event_end">
                <label for="field-event_end">End{!! printRequired() !!}</label>
                <input type="text" name="event_end" id="field-event_end" class="form-control @error('event_end') is-invalid @enderror datetimepicker-input" data-toggle="datetimepicker" data-target="#field-event_end">
                @error('event_end')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="form-group" id="form-event_placce">
            <label for="field-event_place">Place</label>
            <textarea name="event_place" id="field-event_place" class="form-control @error('event_place') is-invalid @enderror" placeholder="Place Location" rows="3">{!! $event->event_place !!}</textarea>
            @error('event_place')
            <div class="invalid-feedback">{{ $message }}</div>
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
<!-- Summernote -->
<script src="{{ mix('adminlte/plugins/summernote/summernote-bs4.min.js') }}"></script>
<!-- Tempus Dominus -->
<script src="{{ mix('adminlte/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.js') }}"></script>
<!-- Select2 -->
<script src="{{ mix('adminlte/plugins/select2/js/select2.full.min.js') }}"></script>
<!-- bs-custom-file-input -->
<script src="{{ mix('adminlte/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
@endsection

@section('inline_js')
<script>
    $(document).ready(function(){
        bsCustomFileInput.init();

        $('#field-event_start').datetimepicker({
            buttons: {
                showClear: true,
                showToday: true,
            },
            useCurrent: false,
            format: "MMMM Do YYYY, HH:mm",
            defaultDate: "{{ !empty($event->event_start) ? date('Y-m-d H:i:00', strtotime($event->event_start)) : date('Y-m-d H:i:00') }}",
        });
        $('#field-event_end').datetimepicker({
            buttons: {
                showClear: true,
                showToday: true,
            },
            useCurrent: false,
            format: "MMMM Do YYYY, HH:mm",
            minDate: "{{ !empty($event->event_start) ? date('Y-m-d H:i:00', strtotime($event->event_start)) : date('Y-m-d H:i:00') }}",
            defaultDate: "{{ $event->event_end ? date('Y-m-d H:i:00', strtotime($event->event_end)) : date('Y-m-d H:i:00') }}"
        });
        $("#field-event_start").on("change.datetimepicker", function (e) {
            $('#field-event_end').datetimepicker('minDate', e.date);
        });
        $("#field-event_end").on("change.datetimepicker", function (e) {
            $('#field-event_start').datetimepicker('maxDate', e.date);
        });

        $("#field-event_description").summernote({
            'height': 250,
            'placeholder': 'Start writing or type...',
        });
    });
</script>
@endsection