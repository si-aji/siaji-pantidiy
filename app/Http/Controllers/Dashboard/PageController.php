<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Page;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('content.dashboard.page.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('content.dashboard.page.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate_published = ['nullable'];

        if($request->page_content == '<p><br/></p>'){
            $request->merge(['page_content' => null]);
        }
        if($request->has('page_immediately') && $request->page_immediately == 'true'){
            $validate_published = ['nullable'];
        } else {
            if($request->page_status == 'published'){
                $validate_published = ['required'];
            }
        }
        $request->validate([
            'page_title' => ['required', 'string', 'max:191'],
            'page_slug' => ['required', 'string', 'max:191', 'unique:sa_page,page_slug'],
            'page_status' => ['required', 'string', 'in:draft,published'],
            'page_published' => $validate_published,
            'page_content' => ['required', 'string']
        ]);

        $page = new Page;
        $page->page_title = $request->page_title;
        $page->page_slug = $request->page_slug;
        $page->page_status = $request->page_status;
        $page->page_published = ($request->has('page_immediately') && $request->page_immediately == 'true' ? date('Y-m-d H:i:00') : ($request->page_status == 'published' ? $request->page_published : null));
        $page->page_content = $request->page_content;
        $page->save();

        return redirect()->route('dashboard.page.index')->with([
            'action' => 'Page Store',
            'message' => 'Page successfully added'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $page = Page::where('page_slug', $id)->firstOrFail();
        return view('content.dashboard.page.show', compact('page'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $page = Page::where('page_slug', $id)->firstOrFail();
        return view('content.dashboard.page.edit', compact('page'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $page = Page::where('page_slug', $id)->firstOrFail();
        $validate_published = ['nullable'];

        if($request->page_content == '<p><br/></p>'){
            $request->merge(['page_content' => null]);
        }
        if($request->has('page_immediately') && $request->page_immediately == 'true'){
            $validate_published = ['nullable'];
        } else {
            if($request->page_status == 'published'){
                $validate_published = ['required'];
            }
        }
        $request->validate([
            'page_title' => ['required', 'string', 'max:191'],
            'page_slug' => ['required', 'string', 'max:191', 'unique:sa_page,page_slug,'.$page->id],
            'page_status' => ['required', 'string', 'in:draft,published'],
            'page_published' => $validate_published,
            'page_content' => ['required', 'string']
        ]);

        $page->page_title = $request->page_title;
        $page->page_slug = $request->page_slug;
        $page->page_status = $request->page_status;
        $page->page_published = ($request->has('page_immediately') && $request->page_immediately == 'true' ? date('Y-m-d H:i:00') : ($request->page_status == 'published' ? $request->page_published : null));
        $page->page_content = $request->page_content;
        $page->save();

        return redirect()->route('dashboard.page.index')->with([
            'action' => 'Page Update',
            'message' => 'Page successfully updated'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Page  $page
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
        $data = Page::query();

        return datatables()
            ->of($data)
            ->toJson();
    }
}
