<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Panti;
use App\Models\PantiLiputan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PantiLiputanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\Models\PantiLiputan  $id (slug)
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $panti = Panti::where('panti_slug', $id)->first();

        return view('content.dashboard.panti.liputan.create', compact('panti'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Models\PantiLiputan  $id (slug)
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($id, Request $request)
    {
        $panti = Panti::where('panti_slug', $id)->first();
        
        ($request->liputan_content == '<p><br/></p>' ? $request->merge(['liputan_content' => null]) : '');
        $request->validate([
            'liputan_date' => ['required'],
            'liputan_content' => ['required', 'string']
        ]);

        $liputan = new PantiLiputan;
        $liputan->panti_id = $panti->id;
        $liputan->user_id = $request->user_id;
        $liputan->liputan_date = $request->liputan_date;
        $liputan->liputan_content = $request->liputan_content;
        $liputan->save();

        return redirect()->route('dashboard.panti.show', $panti->panti_slug)->with([
            'action' => 'Liputan Store',
            'message' => 'Panti Liputan successfully added'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PantiLiputan  $id (slug)
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PantiLiputan  $id (slug)
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
     * @param  \App\Models\PantiLiputan  $id (slug)
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PantiLiputan  $id (slug)
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
        $data = PantiLiputan::query();

        if(isset($_GET['panti_id'])){
            $data->where('panti_id', $_GET['panti_id']);
        }

        return datatables()
            ->of($data->with('user'))
            ->toJson();
    }
}
