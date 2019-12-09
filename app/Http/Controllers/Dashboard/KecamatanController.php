<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Kecamatan;
use App\Models\Kabupaten;
use App\Models\Provinsi;


class KecamatanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $provinsi = Provinsi::orderBy('provinsi_name', 'asc')->get();
        return view('content.dashboard.location.kecamatan.index', compact('provinsi'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $store = null;
        $request->validate([
            'kecamatan_name' => ['required', 'string', 'unique:sa_lkecamatan,kecamatan_name']
        ]);

        $store = Kecamatan::create([
            'kabupaten_id' => $request->kabupaten_id,
            'kecamatan_name' => $request->kecamatan_name
        ]);

        return response()->json([
            'action' => 'Store',
            'message' => 'Kecamatan successfully added',
            'data' => $store
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Kecamatan  $kecamatan
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Kecamatan  $kecamatan
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Kecamatan  $kecamatan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $update = Kecamatan::findOrFail($id);
        $request->validate([
            'kecamatan_name' => ['required', 'string', 'unique:sa_lkecamatan,kecamatan_name,'.$id]
        ]);

        $update->kabupaten_id = $request->kabupaten_id;
        $update->kecamatan_name = $request->kecamatan_name;
        $update->save();

        return response()->json([
            'action' => 'Update',
            'message' => 'Kecamatan successfully updated',
            'data' => $update
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Kecamatan  $kecamatan
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * DataTable
     */
    public function datatableAll()
    {
        // DB::enableQueryLog();
        $data = Kecamatan::query();

        if(isset($_GET['kabupaten'])){
            if($_GET['kabupaten'] != "none"){
                $data = $data->whereKabupatenId($_GET['kabupaten'])->get();
            } else {
                $data = [];
            }
        }

        return datatables()
            ->of($data)
            ->toJson();
    }

    /**
     * JSON
     */
    public function jsonAll()
    {
        $data = Kecamatan::all();
        return response()->json([
            'status' => 'success',
            'message' => 'Data Fetched',
            'data' => $data
        ]);
    }

    public function jsonId($id)
    {
        $data = Kecamatan::findOrFail($id);
        return response()->json([
            'status' => 'success',
            'message' => 'Data Fetched',
            'data' => $data
        ]);
    }
}
