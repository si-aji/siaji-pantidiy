@extends('layouts.dashboard', [
    'wsecond_title' => 'Panti - Detail',
    'menu' => 'panti',
    'sub_menu' => 'list',
    'alert' => [
        'action' => Session::get('action') ?? null,
        'message' => Session::get('message') ?? null
    ],
    'content_header' => [
        'title' => 'Panti',
        'desc' => null,
        'breadcrumb' => [
            [
                'url' => route('dashboard.index'),
                'text' => 'Dashboard',
                'active' => false
            ], [
                'url' => route('dashboard.panti.index'),
                'text' => 'Panti',
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
@endsection

@section('content')
<div class="card">
    <div class="card-header card-secondary card-outline">
        <h1 class="card-title">Detail {{ $panti->panti_name }}</h1>
        <div class="card-tools">
            <a href="{{ route('dashboard.panti.edit', $panti->panti_slug) }}" class="btn btn-warning btn-sm">
                <i class="fas fa-edit"></i> Edit
            </a>
            <a href="{{ route('dashboard.panti.liputan.create', $panti->panti_slug) }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Tambah Liputan
            </a>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-hover table-striped @if(!empty($liputan)) mb-4 @endif">
            <tr>
                <th width="30%">Name</th>
                <td>{{ $panti->panti_name }}</td>
            </tr>
            <tr>
                <th>Slug</th>
                <td>{{ $panti->panti_slug }}</td>
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
            <tr>
                <th>Description</th>
                <td>
                    {!! $panti->panti_description !!}
                </td>
            </tr>
        </table>

        @if(!empty($liputan))
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
        @endif
    </div>
</div>
@endsection

@section('plugins_js')
<script src="{{ mix('adminlte/js/siaji.js') }}"></script>

<!-- Datatable -->
<script src="{{ mix('adminlte/plugins/datatables/jquery.dataTables.js') }}"></script>
<script src="{{ mix('adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.js') }}"></script>
@endsection

@section('inline_js')
<script>
    let liputan_table = $("#liputan_table").DataTable({
        order: [0, 'desc'],
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('dashboard.json.datatable.panti.liputan.all') }}",
            type: "GET",
            data: function(d){
                console.log(d);
                d.panti_id = "{{ $panti->id }}";
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
                        +"<a href='{{ route('dashboard.panti.liputan.index') }}/"+data.panti.panti_slug+"/"+data.id+"' class='btn btn-caction btn-info btn-sm'><i class='far fa-eye'></i></a>"
                    +"</div>"
                }
            }
        ],
    });
</script>
@endsection