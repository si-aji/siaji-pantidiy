<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Provinsi;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Panti;

class PantiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kabupaten = $kecamatan = null;
        $provinsi = Provinsi::orderBy('provinsi_name', 'asc')->get();
        $panti = Panti::orderBy('kecamatan_id', 'asc');

        if(isset($_GET['provinsi'])){
            if($_GET['provinsi'] != 'all'){
                $panti->where('provinsi_id', $_GET['provinsi']);
            }
            if(isset($_GET['kabupaten'])){
                if($_GET['kabupaten'] != 'all'){
                    $kabupaten = Kabupaten::find($_GET['kabupaten']);
                    $panti->where('kabupaten_id', $_GET['kabupaten']);
                }
                if(isset($_GET['kecamatan']) && $_GET['kecamatan'] != 'all'){
                    $kecamatan = Kecamatan::find($_GET['kecamatan']);
                    $panti->where('kecamatan_id', $_GET['kecamatan']);
                }
            }
        }
        $panti = $panti->simplePaginate(4);

        return view('content.public.panti.index', compact(
            'provinsi',
            'kabupaten',
            'kecamatan',
            'panti'
        ));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Panti  $panti
     * @return \Illuminate\Http\Response
     */
    public function show(Panti $panti)
    {
        //
    }
}
