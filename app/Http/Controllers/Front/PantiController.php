<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
        $panti = Panti::query();

        if(isset($_GET['provinsi']) && $_GET['provinsi'] != 'all'){
            $panti->where('provinsi_id', $_GET['provinsi']);
        }
        if(isset($_GET['kabupaten']) && $_GET['kabupaten'] != 'all'){
            $panti->where('kabupaten_id', $_GET['kabupaten']);
        }
        if(isset($_GET['kecamatan']) && $_GET['kecamatan'] != 'all'){
            $panti->where('kecamatan_id', $_GET['kecamatan']);
        }

        return response()->json($panti->get());
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
