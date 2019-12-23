<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Provinsi;
use App\Models\Panti;
use App\Models\PantiLiputan;
use Illuminate\Http\Request;

class PantiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $province = Provinsi::orderBy('provinsi_name', 'asc')->get();
        return view('content.dashboard.panti.index', compact('province'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $province = Provinsi::orderBy('provinsi_name', 'asc')->get();
        return view('content.dashboard.panti.create', compact('province'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        ($request->provinsi_id == 'none' ? $request->merge(['provinsi_id' => null]) : '');
        ($request->kabupaten_id == 'none' ? $request->merge(['kabupaten_id' => null]) : '');
        ($request->kecamatan_id == 'none' ? $request->merge(['kecamatan_id' => null]) : '');
        ($request->panti_description == '<p><br/></p>' ? $request->merge(['panti_description' => null]) : '');

        $vprovinsi_id = $vkabupaten_id = $vkecamatan_id = ['nullable'];
        if(!empty($request->provinsi_id)){
            $vprovinsi_id = $vkabupaten_id = $vkecamatan_id = ['required'];
        }
        $request->validate([
            'provinsi_id' => $vprovinsi_id,
            'kabupaten_id' => $vkabupaten_id,
            'kecamatan_id' => $vkecamatan_id,

            'panti_name' => ['required', 'string', 'max:255'],
            'panti_slug' => ['required', 'string', 'max:255', 'unique:sa_panti,panti_slug']
        ]);

        $panti = new Panti;
        $panti->provinsi_id = $request->provinsi_id;
        $panti->kabupaten_id = $request->kabupaten_id;
        $panti->kecamatan_id = $request->kecamatan_id;
        $panti->panti_name = $request->panti_name;
        $panti->panti_slug = $request->panti_slug;
        $panti->panti_alamat = $request->panti_address;
        $panti->panti_description = $request->panti_description;
        $panti->save();

        return redirect()->route('dashboard.panti.index')->with([
            'action' => 'Store',
            'message' => 'Panti successfully added'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Panti  $panti
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $liputan = null;
        $panti = Panti::where('panti_slug', $id)->first();
        if($panti->pantiLiputan()->exists()){
            $liputan = PantiLiputan::where('panti_id', $panti->id)->orderBy('liputan_date', 'desc')->get();
        }
        return view('content.dashboard.panti.show', compact('panti', 'liputan'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Panti  $panti
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $panti = Panti::wherePantiSlug($id)->first();
        $province = Provinsi::orderBy('provinsi_name', 'asc')->get();
        return view('content.dashboard.panti.edit', compact('panti', 'province'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Panti  $panti
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        ($request->provinsi_id == 'none' ? $request->merge(['provinsi_id' => null]) : '');
        ($request->kabupaten_id == 'none' ? $request->merge(['kabupaten_id' => null]) : '');
        ($request->kecamatan_id == 'none' ? $request->merge(['kecamatan_id' => null]) : '');
        ($request->panti_description == '<p><br/></p>' ? $request->merge(['panti_description' => null]) : '');

        $vprovinsi_id = $vkabupaten_id = $vkecamatan_id = ['nullable'];
        if(!empty($request->provinsi_id)){
            $vprovinsi_id = $vkabupaten_id = $vkecamatan_id = ['required'];
        }
        $request->validate([
            'provinsi_id' => $vprovinsi_id,
            'kabupaten_id' => $vkabupaten_id,
            'kecamatan_id' => $vkecamatan_id,

            'panti_name' => ['required', 'string', 'max:255'],
            'panti_slug' => ['required', 'string', 'max:255', 'unique:sa_panti,panti_slug,'.$id]
        ]);

        $panti = Panti::findOrFail($id);
        $panti->provinsi_id = $request->provinsi_id;
        $panti->kabupaten_id = $request->kabupaten_id;
        $panti->kecamatan_id = $request->kecamatan_id;
        $panti->panti_name = $request->panti_name;
        $panti->panti_slug = $request->panti_slug;
        $panti->panti_alamat = $request->panti_address;
        $panti->panti_description = $request->panti_description;
        $panti->save();

        return redirect()->route('dashboard.panti.index')->with([
            'action' => 'Update',
            'message' => 'Panti successfully updated'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Panti  $panti
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
        $data = Panti::query();

        if($_GET['filter'] == 'filtered'){
            if($_GET['provinsi'] != 'none'){
                $data->where('provinsi_id', $_GET['provinsi']);
            }

            if($_GET['kabupaten'] != 'none'){
                $data->where('kabupaten_id', $_GET['kabupaten']);
            }

            if($_GET['kecamatan'] != 'none'){
                $data->where('kecamatan_id', $_GET['kecamatan']);
            }
        }

        return datatables()
            ->of($data->with('provinsi', 'kabupaten', 'kecamatan'))
            ->toJson();
    }
}
