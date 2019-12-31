<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Provinsi;

class ProvinsiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('content.dashboard.location.provinsi.index');
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
            'provinsi_name' => ['required', 'string', 'unique:sa_lprovinsi,provinsi_name']
        ]);

        $store = Provinsi::create([
            'provinsi_name' => $request->provinsi_name
        ]);

        return response()->json([
            'action' => 'Store',
            'message' => 'Provinsi successfully added',
            'data' => $store
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Provinsi  $provinsi
     * @return \Illuminate\Http\Response
     */
    public function show(Provinsi $provinsi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Provinsi  $provinsi
     * @return \Illuminate\Http\Response
     */
    public function edit(Provinsi $provinsi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Provinsi  $provinsi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $update = null;
        $request->validate([
            'provinsi_name' => ['required', 'string', 'unique:sa_lprovinsi,provinsi_name,'.$id]
        ]);

        $update = Provinsi::findOrFail($id);
        $update->provinsi_name = $request->provinsi_name;
        $update->save();

        return response()->json([
            'action' => 'Update',
            'message' => 'Provinsi successfully update',
            'data' => $update
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Provinsi  $provinsi
     * @return \Illuminate\Http\Response
     */
    public function destroy(Provinsi $provinsi)
    {
        //
    }

    /**
     * DataTable
     */
    public function datatableAll()
    {
        $data = Provinsi::query();

        return datatables()
            ->of($data)
            ->toJson();
    }

    /**
     * Select2
     */
    public function select2(Request $request)
    {
        $data = Provinsi::all();
        if($request->has('search') && $request->search != ''){
            // Apply search param
            $data = Provinsi::where('provinsi_name', 'LIKE', '%'.$request->search.'%')->orderBy('provinsi_name', 'asc')->get();
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Data Fetched',
            'data' => $data
        ]);
    }

    /**
     * JSON
     */
    public function jsonAll()
    {
        $data = Provinsi::all();
        return response()->json([
            'status' => 'success',
            'message' => 'Data Fetched',
            'data' => $data
        ]);
    }

    public function jsonId($id)
    {
        $data = Provinsi::findOrFail($id);
        return response()->json([
            'status' => 'success',
            'message' => 'Data Fetched',
            'data' => $data
        ]);
    }
}
