<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Category;
use App\Models\Keyword;
use App\Models\Post;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('content.dashboard.post.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = Category::orderBy('category_title')->get();
        return view('content.dashboard.post.create', compact('category'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate_published = $validate_category = ['nullable'];
        if($request->post_content == '<p><br/></p>'){
            $request->merge(['post_content' => null]);
        }
        if($request->has('post_immediately') && $request->post_immediately == 'true'){
            $validate_published = ['nullable'];
        } else {
            if($request->post_status == 'published'){
                $validate_published = ['required'];
            }
        }
        if($request->category_id != "null"){
            $validate_category = ['nullable', 'exists:sa_category,id'];
        }
        $request->validate([
            'category_id' => $validate_category,
            'post_title' => ['required', 'string', 'max:255'],
            'post_slug' => ['required', 'string', 'max:255', 'unique:sa_post,post_slug'],
            'post_thumbnail' => ['nullable', 'mimes:jpg,jpeg,png'],
            'post_content' => ['required', 'string'],
            'post_shareable' => ['nullable'],
            'post_commentable' => ['nullable'],
            'post_status' => ['required', 'in:published,draft'],
            'post_published' => $validate_published
        ]);

        $post = new Post;
        $post->author_id = $request->author_id;
        $post->category_id = $request->category_id != "null" ? $request->category_id : null;
        $post->post_title = $request->post_title;
        $post->post_slug = $request->post_slug;
        $post->post_content = $request->post_content;
        $post->post_shareable = $request->has('post_shareable') && $request->post_shareable == 'true' ? true : false;
        $post->post_commentable = $request->has('post_commentable') && $request->post_commentable == 'true' ? true : false;
        $post->post_status = $request->post_status;
        if($request->has('post_immediately') && $request->post_immediately == 'true'){
            $post->post_published = date('Y-m-d H:i:00');
        } else {
            if($request->post_status == 'published'){
                $post->post_published = $request->post_published;
            } else {
                $post->post_published = null;
            }
        }
        $post->save();
        $post->keyword()->attach($request->keyword_id);

        return redirect()->route('dashboard.post.index')->with([
            'action' => 'Store',
            'message' => 'Post successfully added'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::where('post_slug', $id)->firstOrFail();
        return view('content.dashboard.post.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::where('post_slug', $id)->firstOrFail();
        $category = Category::orderBy('category_title')->get();
        return view('content.dashboard.post.edit', compact('category', 'post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $post = Post::where('post_slug', $id)->firstOrFail();

        $validate_published = $validate_category = ['nullable'];
        if($request->post_content == '<p><br/></p>'){
            $request->merge(['post_content' => null]);
        }
        if($request->has('post_immediately') && $request->post_immediately == 'true'){
            $validate_published = ['nullable'];
        } else {
            if($request->post_status == 'published'){
                $validate_published = ['required'];
            }
        }
        if($request->category_id != "null"){
            $validate_category = ['nullable', 'exists:sa_category,id'];
        }
        $request->validate([
            'category_id' => $validate_category,
            'post_title' => ['required', 'string', 'max:255'],
            'post_slug' => ['required', 'string', 'max:255', 'unique:sa_post,post_slug,'.$post->id],
            'post_thumbnail' => ['nullable', 'mimes:jpg,jpeg,png'],
            'post_content' => ['required', 'string'],
            'post_shareable' => ['nullable'],
            'post_commentable' => ['nullable'],
            'post_status' => ['required', 'in:published,draft'],
            'post_published' => $validate_published
        ]);

        // return response()->json([
        //     'status' => $request->post_status,
        //     'published' => $request->post_published
        // ]);

        $post->author_id = auth()->user()->id;
        $post->category_id = $request->category_id != "null" ? $request->category_id : null;
        $post->post_title = $request->post_title;
        $post->post_slug = $request->post_slug;
        $post->post_content = $request->post_content;
        $post->post_shareable = $request->has('post_shareable') && $request->post_shareable == 'true' ? true : false;
        $post->post_commentable = $request->has('post_commentable') && $request->post_commentable == 'true' ? true : false;
        $post->post_status = $request->post_status;
        if($request->has('post_immediately') && $request->post_immediately == 'true'){
            $post->post_published = date('Y-m-d H:i:00');
        } else {
            if($request->post_status == 'published'){
                $post->post_published = $request->post_published;
            } else {
                $post->post_published = null;
            }
        }

        if($post->isDirty()){
            if($post->author_id != $request->author_id){
                $post->editor_id = $request->author_id;
            } else {
                $post->editor_id = null;
            }
        }
        $post->save();

        if($post->keyword()->exists()){
            $old_keyword = $post->keyword()->pluck('keyword_id')->toArray();

            if(!empty($request->keyword_id)){
                $add_keyword = arr_diff($request->keyword_id, $old_keyword, 'add');
                $remove_keyword = arr_diff($request->keyword_id, $old_keyword, 'remove');

                if(!empty($add_keyword)){
                    $post->keyword()->attach($add_keyword);
                }
                if(!empty($remove_keyword)){
                    $post->keyword()->detach($remove_keyword);
                }
            } else {
                $post->keyword()->delete();
            }
        } else {
            if(!empty($request->keyword_id)){
                $post->keyword()->attach($request->keyword_id);
            }
        }

        return redirect()->route('dashboard.post.index')->with([
            'action' => 'Update',
            'message' => 'Post successfully updated'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
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
        $data = Post::query();

        return datatables()
            ->of($data->with('category', 'author'))
            ->toJson();
    }
    public function datatableKeyword($slug)
    {
        $keyword = Keyword::where('keyword_slug', $slug)->first();
        // DB::enableQueryLog();
        $data = Post::query();
        $data = $data->whereHas('keyword', function($query) use ($keyword){
            $query->where('keyword_id', $keyword->id);
        });

        return datatables()
            ->of($data->with('category', 'author'))
            ->toJson();
    }
}
