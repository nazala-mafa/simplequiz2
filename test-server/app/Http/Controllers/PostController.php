<?php

namespace App\Http\Controllers;

use App\Models\PostModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return PostModel::orderBy('id', 'desc')->get();
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
            'title' => ['required', 'unique:posts', 'max:255'],
            'body' => ['required'],
        ]);

        PostModel::create([
            'title' => $request->title,
            'body' => $request->body,
            'user_id' => 1,
        ]);

        return response(['message' => 'Post Baru Berhasil Ditambahkan']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = PostModel::select(['posts.*', 'users.name as author'])->where('posts.id', $id)->join('users', 'users.id','=','posts.user_id')->first();
        return response([ 
            'data' => $post
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = PostModel::where('id', $id)->firstOrFail();
        $user->title = $request->title;
        $user->body = $request->body;
        $user->save();

        return response([ 'message' => "Post $user->title Berhasil Diupdate" ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        PostModel::where('id', $id)->delete();
        return response([ 'message' => "Post Berhasil Diupdate" ]);
    }
}
