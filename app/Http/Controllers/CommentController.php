<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreComment;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth')->only(['store','destroy']);
    }
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreComment $request,Post $post)
    {
        //
        // dd($request->content,$request->user()->id,(int)$request->post_id);
        // $post->comments()->create([
        //     'content'=>$request->content,
        //     'post_id'=>84,
        //     'user_id'=>$request->user()->id

        // ]);
        // $request['user_id']=$request->user()->id;
        // dd($request->only(['content','post_id','user_id']));
        // Comment::make($request->only(['content','post_id','user_id']));
        dd($post->id);
        $post->comments()->create([
        'content'=>$request->content,
        'user_id'=>$request->user()->id
        ]);
        return redirect()->back()->withStatus('comment was created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        Comment::finOrFail($id)->update($request->content);
        return Redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id,Request $request)
    {
        $comment=Comment::findOrFail($id);

        $post=(int)$request->input('post');
        // dd((int)$request->input('post'));
        // $this->authorize('comments.delete',[$post,$comment]);
        $this->authorize('delete',[$comment, $post]);
        $comment->delete();

        return redirect()->back();
    }
}
