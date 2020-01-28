<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Post;
use App\Models\Provinsi;
use App\Models\Donation;

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
        $donation = Donation::getDonation()->get();

        return response()->json([
            'donation' => $donation
        ]);

        return view('content.public.index.index', compact(
            'provinsi',
            'articles'
        ));
    }
}
