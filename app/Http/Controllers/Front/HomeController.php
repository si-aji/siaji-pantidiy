<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Post;
use App\Models\Provinsi;

class HomeController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $provinsi = Provinsi::orderBy('provinsi_name', 'asc')->get();
        $articles = Post::getPublishedArticles()->take(3)->get();

        // return response()->json([
        //     'articles' => $articles
        // ]);

        return view('content.public.index.index', compact(
            'provinsi',
            'articles'
        ));
    }
}
