@extends('layouts.dashboard', [
    'wsecond_title' => 'Liputan Panti - Detail',
    'menu' => 'panti',
    'sub_menu' => 'liputan',
    'alert' => [
        'action' => Session::get('action') ?? null,
        'message' => Session::get('message') ?? null
    ],
    'content_header' => [
        'title' => 'Liputan Panti',
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
                'text' => 'Detail',
                'active' => true
            ]
        ]
    ]
])

@section('plugins_css')
<!-- DataTables -->
<link rel="stylesheet" href="{{ mix('adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.css') }}">
<!-- Owl Carousel -->
<link rel="stylesheet" href="{{ mix('adminlte/plugins/owlcarousel/owl.carousel.min.css') }}">
<link rel="stylesheet" href="{{ mix('adminlte/plugins/owlcarousel/owl.theme.default.min.css') }}">
<!-- Lightcase -->
<link rel="stylesheet" href="{{ mix('adminlte/plugins/lightcase/css/lightcase.css') }}">
@endsection

@section('content')
<div class="card">
    <div class="card-header card-secondary card-outline">
        <h1 class="card-title">Detail {{ $liputan->panti->panti_name }}</h1>
        <div class="card-tools btn-group">
            <a href="{{ route('dashboard.panti.show', $liputan->panti->panti_slug) }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-chevron-circle-left"></i> Back
            </a>
            <a href="{{ route('dashboard.panti.liputan.edit', [$liputan->panti->panti_slug, $liputan->id]) }}" class="btn btn-warning btn-sm">
                <i class="fas fa-edit"></i> Edit
            </a>
            <a href="{{ route('dashboard.panti.liputan.create', $panti->panti_slug) }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Tambah Liputan
            </a>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-hover table-striped mb-4" style="table-layout:fixed">
            <tr>
                <th width="30%">Name</th>
                <td>{{ $liputan->panti->panti_name }}</td>
            </tr>
            <tr>
                <th>Tanggal Liputan</th>
                <td>{{ $liputan->liputan_date }}</td>
            </tr>
            <tr>
                <th>Author</th>
                <td>{{ $liputan->author->name }}</td>
            </tr>
            @if(!empty($liputan->editor_id))
            <tr>
                <th>Editor</th>
                <td>{{ $liputan->editor->name }}</td>
            </tr>
            @endif
            <tr>
                <th>Gallery</th>
                <td>
                    @if($liputan->pantiLiputanGallery()->exists())
                    <div class="owl-carousel owl-theme w-100">
                        @foreach($liputan->pantiLiputanGallery as $value)
                        <div class="item" style="width:250px">
                            <a href="{{ asset('img/panti/liputan'.'/'.$value->gallery_fullname) }}" data-rel="lightcase:collection" title="Liputan {{ $liputan->liputan_date }} - {{ $value->gallery_filename }}">
                                <img src="{{ asset('img/panti/liputan'.'/'.$value->gallery_fullname) }}" class="img img-responsive" style="height:200px;object-fit:cover;">
                            </a>
                        </div>
                        @endforeach
                    </div>
                    @else
                    -
                    @endif
                </td>
            </tr>
            <tr>
                <th>Content</th>
                <td>{!! $liputan->liputan_content !!}</td>
            </tr>
        </table>

        <div class="card">
            <div class="card-header card-secondary card-outline">
                <h6 class="mb-0">Liputan Panti</h6>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-hover table-striped" id="liputan_table">
                    <thead>
                        <tr>
                            <th>Tanggal Liputan</th>
                            <th>Author</th>
                            <th>Editor</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('plugins_js')
<script src="{{ mix('adminlte/js/siaji.js') }}"></script>

<!-- Datatable -->
<script src="{{ mix('adminlte/plugins/datatables/jquery.dataTables.js') }}"></script>
<script src="{{ mix('adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.js') }}"></script>
<!-- Owl Carousel -->
<script src="{{ mix('adminlte/plugins/owlcarousel/owl.carousel.min.js') }}"></script>
<!-- Lightcase -->
<script src="{{ mix('adminlte/plugins/lightcase/js/lightcase.js') }}"></script>
@endsection

@section('inline_js')
<script>
    $(document).ready(function(){
        $('a[data-rel^=lightcase]').lightcase();
    });

    $('.owl-carousel').owlCarousel({
        items:3,
        loop:false,
        margin:10,
        dots:true,
        autoWidth:true,
        responsive:{
            0:{
                items:1
            }
        }
    });

    let liputan_table = $("#liputan_table").DataTable({
        order: [0, 'desc'],
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('dashboard.json.datatable.panti.liputan.all') }}",
            type: "GET",
            data: function(d){
                console.log(d);
                d.panti_id = "{{ $liputan->panti->id }}";
            }
        },
        success: function (result) {
            console.log(result);
        },
        columns: [
            { "data": "liputan_date" },
            { "data": "author.name" },
            { "data": "editor.name" },
            { "data": "" }
        ],
        columnDefs: [
            {
                "targets": 0,
                "render": function(row, type, data){
                    if(data.id == "{{ $liputan->id }}"){
                        row += " (Currently Active)";
                    }

                    return row;
                }
            }, {
                "targets": 2,
                "render": function(row, type, data){
                    // console.log(row);
                    if(row != null){
                        return row;
                    } else {
                        return "-";
                    }
                }
            }, {
                "targets": 3,
                "searchable": false,
                "sortable": false,
                "render": function(row, type, data){
                    // console.log(row);
                    return "<div class='btn-group'>"
                        +"<a href='{{ route('dashboard.panti.liputan.index') }}/"+data.panti.panti_slug+"/"+data.id+"/edit' class='btn btn-caction btn-warning btn-sm'><i class='far fa-edit'></i></a>"
                        +"<a href='{{ route('dashboard.panti.liputan.index') }}/"+data.panti.panti_slug+"/"+data.id+"' class='btn btn-caction btn-info btn-sm "+(data.id == '{{ $liputan->id }}' ? 'disabled' : '')+"'><i class='far fa-eye'></i></a>"
                    +"</div>"
                }
            }
        ],
        createdRow: function(row, data, dataIndex, cells) {
            if(data.id == "{{ $liputan->id }}"){
                $(row).addClass('table-primary');
            }
        },
    });
</script>
@endsection