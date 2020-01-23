@extends('layouts.dashboard', [
    'wsecond_title' => 'Donation - Edit',
    'menu' => 'donation',
    'sub_menu' => null,
    'alert' => [
        'action' => Session::get('action') ?? null,
        'message' => Session::get('message') ?? null
    ],
    'content_header' => [
        'title' => 'Donation',
        'desc' => null,
        'breadcrumb' => [
            [
                'url' => route('dashboard.index'),
                'text' => 'Dashboard',
                'active' => false
            ], [
                'url' => route('dashboard.donation.index'),
                'text' => 'Donation',
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
<form class="card" action="{{ route('dashboard.donation.update', $donation->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="card-header card-primary card-outline">
        <h1 class="card-title">Edit Donation</h1>
        <div class="card-tools">
            <a href="{{ route('dashboard.donation.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-chevron-circle-left"></i> Back
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="form-group" id="form-panti">
            <label for="panti">Panti</label>
            <input type="text" name="panti" id="field-panti_id" class="form-control" value="{{ $donation->panti->panti_name }}" readonly>
        </div>

        <div class="form-group" id="form-donation_title">
            <label for="donation_title">Title</label>
            <input type="text" name="donation_title" id="field-donation_title" class="form-control @error('donation_title') is-invalid @enderror" placeholder="Donation Title" value="{{ $donation->donation_title }}">
            @error('donation_title')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group" id="form-amount_needed">
            <label for="field-amount_needed">Amount Needed{!! printRequired() !!}</label>
            <input type="number" name="amount_needed" min="0" id="field-amount_needed" class="form-control @error('amount_needed') is-invalid @enderror" placeholder="Amount Needed" value="{{ $donation->donation_needed }}">
            @error('amount_needed')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group" id="form-donation_description">
            <label for="donation_description">Description{!! printRequired() !!}</label>
            <textarea name="donation_description" id="field-donation_description" class="form-control @error('donation_description') is-invalid @enderror">{!! $donation->donation_description !!}</textarea>
            
            @error('donation_description')
            <div class='invalid-feedback'>{{ $message }}</div>
            @enderror
        </div>

        <div class="form-row">
            <div class="col-12 col-md-6 form-group" id="form-donation_start">
                <label for="field-donation_start">Start{!! printRequired() !!}</label>
                <input type="text" name="donation_start" id="field-donation_start" class="form-control @error('donation_start') is-invalid @enderror datetimepicker-input" data-toggle="datetimepicker" data-target="#field-donation_start" autocomplete="off">
                @error('donation_start')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-12 col-md-6 form-group" id="form-donation_end">
                <label for="field-donation_end">End{!! printRequired('**', 'Donation End is Required if Checkbox is checked') !!}</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <input type="checkbox" id="field-donation_hasdeadline" name="donation_hasdeadline" value="true" onchange="checkDeadline()" {{ $donation->donation_hasdeadline ? 'checked' : '' }}>
                        </span>
                    </div>

                    <input type="text" name="donation_end" id="field-donation_end" class="form-control @error('donation_end') is-invalid @enderror datetimepicker-input" data-toggle="datetimepicker" data-target="#field-donation_end" {{ $donation->donation_hasdeadline ? '' : 'disabled' }} autocomplete="off">
                    @error('donation_end')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
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
@endsection

@section('inline_js')
<script>
    $(document).ready(function(){
        $('#field-donation_start').datetimepicker({
            buttons: {
                showClear: true,
                showToday: true,
            },
            useCurrent: false,
            format: "MMMM Do, YYYY",
            defaultDate: "{{ date('Y-m-d', strtotime($donation->donation_start)) }}",
        });
        $('#field-donation_end').datetimepicker({
            buttons: {
                showClear: true,
                showToday: true,
            },
            useCurrent: false,
            format: "MMMM Do, YYYY",
            minDate: "{{ date('Y-m-d', strtotime($donation->donation_start)) }}",
            {!! $donation->donation_hasdeadline ? 'defaultDate: "'.(!empty($donation->donation_end) ? date('Y-m-d', strtotime($donation->donation_end)) : '').'"' : '' !!}
        });
        $("#field-donation_start").on("change.datetimepicker", function (e) {
            $('#field-donation_end').datetimepicker('minDate', e.date);
        });
        $("#field-donation_end").on("change.datetimepicker", function (e) {
            $('#field-donation_start').datetimepicker('maxDate', e.date);
        });

        $("#field-donation_description").summernote({
            'height': 250,
            'placeholder': 'Start writing or type...',
        });
    });

    function checkDeadline(){
        let has_deadline = $("#field-donation_hasdeadline");

        if(has_deadline.is(':checked')){
            $('#field-donation_end').datetimepicker('enable');
        } else {
            $('#field-donation_end').datetimepicker('disable');
        }
    }
</script>
@endsection