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
        $panti = Panti::with(array('pantiGallery' => function($query){
            $query->where('is_thumb', true);
        }))->orderBy('id', 'desc');

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
        if(isset($_GET['keyword'])){
            if($_GET['keyword'] != ''){
                $panti->where('panti_name', 'like', '%'.$_GET['keyword'].'%');
            }
        }
        $panti = $panti->paginate(4);

        // return response()->json($panti);

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
    public function show($slug)
    {
        $panti = Panti::wherePantiSlug($slug)->firstOrFail();

        $prev = Panti::where('id', '>', $panti->id)->min('id');
        if($prev){ $prev = Panti::find($prev); }
        $next = Panti::where('id', '<', $panti->id)->max('id');
        if($next){ $next = Panti::find($next); }

        // return response()->json([
        //     'prev' => $prev ? $prev->id.' / '.$prev->panti_slug : '-',
        //     'current' => $panti->id,
        //     'next' => $next ? $next->id.' / '.$next->panti_slug : '-',
        // ]);

        return view('content.public.panti.show', compact('panti', 'prev', 'next'));
    }
}
