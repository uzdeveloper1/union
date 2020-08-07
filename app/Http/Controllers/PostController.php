<?php

namespace App\Http\Controllers;

use App\PostCategory;
use Illuminate\Http\Request;
use TCG\Voyager\Models\Post;

class PostController extends Controller
{
    public function postsByCategory(PostCategory $category){
        $posts = $category->posts;
        return view('union.post-by-category', [
            'category' =>$category,
            'posts' => $posts
        ]);
    }

    public function singlePost(Post $post){
        $posts = Post::latest()->paginate(3);
        return view('union.single-post',
            [
                'post'=>$post,
                'latest_posts' => $posts
            ]
        );
    }
}
