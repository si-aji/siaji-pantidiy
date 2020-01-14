<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Post;

class SinglePageController extends Controller
{
    public function index($type = 'article', $slug)
    {
        $data = null;
        switch($type){
            case 'article':
                $data = Post::where('post_slug', $slug)->get();
                break;
        }

        return response()->json([
            'message' => 'Data Fetched',
            'data' => $data
        ]);
    }
}
