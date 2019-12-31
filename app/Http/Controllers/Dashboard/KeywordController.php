<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Keyword;

class KeywordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $keyword = Keyword::all();
        return view('content.dashboard.keyword.index', compact('keyword'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('content.dashboard.keyword.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'keyword_title' => ['required', 'string', 'max:255', 'unique:sa_keyword,keyword_title'],
            'keyword_slug' => ['required', 'string', 'max:255', 'unique:sa_keyword,keyword_slug'],
        ]);

        $keyword = new Keyword;
        $keyword->keyword_title = $request->keyword_title;
        $keyword->keyword_slug = $request->keyword_slug;
        $keyword->save();

        return redirect()->route('dashboard.keyword.index')->with([
            'action' => 'Store',
            'message' => 'Keyword successfully added'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Keyword $id (slug)
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $keyword = Keyword::where('keyword_slug', $id)->firstOrFail();
        return view('content.dashboard.keyword.show', compact('keyword'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Keyword $id (slug)
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $keyword = Keyword::where('keyword_slug', $id)->firstOrFail();
        return view('content.dashboard.keyword.edit', compact('keyword'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Keyword $id (slug)
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $keyword = Keyword::where('keyword_slug', $id)->firstOrFail();
        $request->validate([
            'keyword_title' => ['required', 'string', 'max:255', 'unique:sa_keyword,keyword_title,'.$keyword->id],
            'keyword_slug' => ['required', 'string', 'max:255', 'unique:sa_keyword,keyword_slug,'.$keyword->id],
        ]);

        $keyword->keyword_title = $request->keyword_title;
        $keyword->keyword_slug = $request->keyword_slug;
        $keyword->save();

        return redirect()->route('dashboard.keyword.index')->with([
            'action' => 'Update',
            'message' => 'Keyword successfully updated'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Keyword $id (slug)
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
