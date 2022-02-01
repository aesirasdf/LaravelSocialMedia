<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    //

    public function __construct(){
        $this->middleware("auth");
    }

    public function index(){
        $Posts = Post::orderBy("created_at", "desc")->get();
        return view("posts.index", compact("Posts"));
    }

    public function store(Request $request){
        $data = $this->validate($request, [
            "content" => "required",
        ]);
        auth()->user()->Posts()->create($data);
        return redirect()->route("posts");
    }

    public function delete($id){
        $post = Post::find($id);
        if(is_null($post))
            abort(404);
        else if($post->user_id == auth()->user()->id ){
            $post->delete();
        }
        else{
            abort(403);
        }
        return redirect()->route("posts");
    }

    public function update(Request $request, $id){
        $post = Post::find($id);
        if(is_null($post))
            abort(404);
        else if($post->user_id == auth()->user()->id ){
            $data = $this->validate($request, [
                "content" => "required",
            ]);
            $post->update($data);
        }
        else{
            abort(403);
        }
        return redirect()->route("posts");
    }

    public function show($id){
        $Post = Post::find($id);
        if(is_null($Post))
            abort(404);
        return view("posts.show", compact("Post"));
    }

}
