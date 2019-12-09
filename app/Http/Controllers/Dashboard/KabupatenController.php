<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Provinsi;
use App\Models\Kabupaten;
use DB;

class KabupatenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $provinsi = Provinsi::orderBy('provinsi_name', 'asc')->get();
        return view('content.dashboard.location.kabupaten.index', compact('provinsi'));
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
            'kabupaten_name' => ['required', 'string', 'unique:sa_lkabupaten,kabupaten_name']
        ]);

        $store = Kabupaten::create([
            'provinsi_id' => $request->provinsi_id,
            'kabupaten_name' => $request->kabupaten_name
        ]);

        return response()->json([
            'action' => 'Store',
            'message' => 'Kabupaten successfully added',
            'data' => $store
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $update = Kabupaten::findOrFail($id);
        $request->validate([
            'kabupaten_name' => ['required', 'string', 'unique:sa_lkabupaten,kabupaten_name,'.$id]
        ]);

        $update->provinsi_id = $request->provinsi_id;
        $update->kabupaten_name = $request->kabupaten_name;
        $update->save();

        return response()->json([
            'action' => 'Update',
            'message' => 'Kabupaten successfully updated',
            'data' => $update
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
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

        $data = Kabupaten::query();

        if(isset($_GET['provinsi'])){
            if($_GET['provinsi'] != "none"){
                $data = $data->whereProvinsiId($_GET['provinsi'])->get();
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
        $data = Kabupaten::all();
        return response()->json([
            'status' => 'success',
            'message' => 'Data Fetched',
            'data' => $data
        ]);
    }

    public function jsonId($id)
    {
        $data = Kabupaten::findOrFail($id);
        return response()->json([
            'status' => 'success',
            'message' => 'Data Fetched',
            'data' => $data
        ]);
    }
}
