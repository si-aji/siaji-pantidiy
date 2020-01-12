@extends('layouts.dashboard', [
    'wsecond_title' => 'Donation - Create',
    'menu' => 'panti',
    'sub_menu' => 'donation',
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
<form class="card" action="{{ route('dashboard.donation.store') }}" method="POST">
    @csrf

    <div class="card-header card-primary card-outline">
        <h1 class="card-title">Add new Donation</h1>
        <div class="card-tools">
            <a href="{{ route('dashboard.donation.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-chevron-circle-left"></i> Back
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="form-group" id="field-panti_id">
            <label for="panti_id">Panti</label>
            <select class="form-control select2" name="panti_id" id="panti_id">
            </select>
        </div>

        <div class="form-group" id="field-donation_title">
            <label for="donation_title">Title</label>
            <input type="text" name="donation_title" id="donation_title" class="form-control @error('donation_title') is-invalid @enderror" placeholder="Donation Title">
            @error('donation_title')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group" id="form-amount_needed">
            <label for="field-amount_needed">Amount Needed</label>
            <input type="number" name="amount_needed" min="0" id="field-amount_needed" class="form-control @error('amount_needed') is-invalid @enderror" placeholder="Amount Needed">
            @error('amount_needed')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group" id="field-donation_description">
            <label for="donation_description">Description</label>
            <textarea name="donation_description" id="donation_description" class="form-control @error('donation_description') is-invalid @enderror">{!! old('donation_description') !!}</textarea>
            
            @error('donation_description')
            <div class='invalid-feedback'>{{ $message }}</div>
            @enderror
        </div>

        <div class="form-row">
            <div class="col-12 col-md-6 form-group" id="form-donation_start">
                <label for="field-donation_start">Start</label>
                <input type="text" name="donation_start" id="field-donation_start" class="form-control @error('donation_start') is-invalid @enderror datetimepicker-input" data-toggle="datetimepicker" data-target="#field-donation_start">
                @error('donation_start')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-12 col-md-6 form-group" id="form-donation_end">
                <label for="field-donation_end">End</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">
                            <input type="checkbox" id="field-donation_hasdeadline" name="donation_hasdeadline" value="true" onchange="checkDeadline()" {{ old('donation_hasdeadline') == 'true' ? 'checked' : '' }}>
                        </span>
                    </div>

                    <input type="text" name="donation_end" id="field-donation_end" class="form-control @error('donation_end') is-invalid @enderror datetimepicker-input" data-toggle="datetimepicker" data-target="#field-donation_end" {{ old('donation_hasdeadline') != 'true' ? 'disabled' : '' }}>
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
        let select2_query = {};
        $('#panti_id').select2({
            placeholder: 'Search Panti',
            minimumInputLength: 3,
            allowClear: true,
            ajax: {
                url: "{{ route('dashboard.select2.panti.select2') }}",
                // url: function(params){
                //     console.log(params);
                //     return "{{ route('dashboard.select2.panti.select2') }}"+params.term;
                // },
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
                        obj.text = obj.panti_name;

                        if(obj.provinsi_id != null){
                            obj.text += ' / Prov. '+obj.provinsi.provinsi_name
                        }
                        if(obj.kabupaten_id != null){
                            obj.text += ' / Kab. : '+obj.kabupaten.kabupaten_name
                        }
                        if(obj.kecamatan_id != null){
                            obj.text += ' / Kec. : '+obj.kecamatan.kecamatan_name
                        }

                        return obj;
                    });
                    params.page = params.page || 1;

                    console.log(items);
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

        $('#field-donation_start').datetimepicker({
            buttons: {
                showClear: true,
                showToday: true,
            },
            useCurrent: false,
            format: "MMMM Do, YYYY",
            defaultDate: "{{ !empty(old('donation_start')) ? date('Y-m-d', strtotime(old('donation_start'))) : date('Y-m-d') }}",
        });
        $('#field-donation_end').datetimepicker({
            buttons: {
                showClear: true,
                showToday: true,
            },
            useCurrent: false,
            format: "MMMM Do, YYYY",
            minDate: "{{ !empty(old('donation_start')) ? date('Y-m-d', strtotime(old('donation_start'))) : date('Y-m-d') }}",
            {!! old('donation_hasdeadline') ? 'defaultDate: "'.(old('donation_end') ? date('Y-m-d', strtotime(old('donation_end'))) : '').'"' : '' !!}
        });
        $("#field-donation_start").on("change.datetimepicker", function (e) {
            $('#field-donation_end').datetimepicker('minDate', e.date);
        });
        $("#field-donation_end").on("change.datetimepicker", function (e) {
            $('#field-donation_start').datetimepicker('maxDate', e.date);
        });

        $("#donation_description").summernote({
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