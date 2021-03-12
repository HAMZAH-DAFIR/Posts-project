<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Image;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Requests\StorePost;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Database\Eloquent\Builder;

class PostController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->only(['edit','destroy','store','update','restore','create','myPost']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // dd(Auth::check());
        return view('posts.index',
        ['posts'=>Post::withCount('comments')->with(['user','tags','picture'])->get() ]
    );
    }
    public function myPost(){
       $posts= Post::withCount('comments')->with(['user','tags'])->where('user_id','=',Auth::user()->id)->get();
    //    dd('hello');
        return view('posts.index',
        ['posts'=>$posts]);

    }
    public function archive()
    {
        return view('posts.index',['posts'=>Post::onlyTrashed()->withCount('comments')->get(),'tab'=>'archive']);
    }
    public function all()
    {
        return view('posts.index',['posts'=>Post::withTrashed()->withCount('comments')->get(),'tab'=>'all']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        // $this->authorize('posts.create');
        $this->authorize('create',Post::class);
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePost $request)
    {
        //

        $validatorData=$request->validated();
        $validatorData['user_id']=$request->user()->id;

        $post= Post::create( $validatorData);

        if($request->hasFile('picture'))
        {
           $path= Storage::putFile('posts',$request->picture);

            $post->picture()->save(Image::make(['path'=>$path]));
        }
        $request->session()->flash('status','the post was created');
        return Redirect()->route('posts.show',['post'=>$post->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // $post=Post::withCount(['comments'=>function($q){
        //     // dd($q);
        //     return $q->with('user');}])->findOrFail($id);
        //     //  $post=Post::withCount('comments')->commentUser()->findOrFail($id);
        // dd($post->comments[0]->user->id);
        $postShow=Cache::remember("show-post-{$id}",100,function() use($id){
            return Post::with(['comments','tags','comments.user'])->findOrFail($id);
        });
        // $commentShow=Cache::remember("comment-post-{$id}",5,function() use($id){
        //     return Comment::with('user')->where('post_id','=',$id)->get();
        // });
        // dd($postShow);
        return view('posts.show',
        ['post'=>$postShow,
        // 'comments'=>$commentShow,

        ]);
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
        $post=Post::findOrFail($id);
        // $this->authorize('posts.update',$post);
        $this->authorize('update',$post);

        return view('posts.edit',['post'=> $post]);
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
        //
        //  dd($request['title']);
        // Cache::forget("show-post-{$id}");
        $post=Post::findOrFail($id);
        $this->authorize('update',$post);

        Post::findOrFail($id)->update(['title'=>$request->input('title'),'content'=>$request->input('content')]);
        if($request->hasFile('picture')){
            $path=$request->file('picture')->store('posts');
            if($post->picture){
                Storage::delete($post->picture->path);
               $id= $post->picture()->update(['path'=>$path]);
            //    dd($id);
            }else{
                // change create() To make() because we applique morph
                $id= $post->picture()->save(Image::make(['path'=>$path]));
            }

            // dd($id,'hello');
        }
        // $post=Post::findOrFail($id);
        // if(Gate::denies('posits.update',$post)){
        //     abort(403,"You can't update this post");
        // }
        // $this->authorize('posts.update',$post);
        // $this->authorize('update',$post);
        // $post->title=$request->input('title');
        // $post->content=$request->input('content');
        // $post->active=$request->input('active');
        // $post->user_id=Auth::id();
        // $post->save();
        $request->session()->flash('status','the post was updated');
        return Redirect()->route("posts.show", ['post'=>$post->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        //
        $post=Post::findOrFail($id);

        // if(Gate::denies('posts.delete',$post)){
        //     abort(403,"You can't delete this post");
        // }
        // $this->authorize('posts.delete',$post);
        $this->authorize('delete',$post);

        $post->delete();

        $request->session()->flash('status','the post was deleted');
        return Redirect()->back();
    }
    public function restore($id){
        $post=Post::onlyTrashed()->whereId($id)->first();
        $this->authorize('restore',$post);
        $post->restore();
        return Redirect()->back();
    }
    public function forcedelete($id){

        $post=Post::onlyTrashed()->whereId($id)->first();
        $this->authorize('forcedelete',$post);
        $post->forceDelete();


        return Redirect()->back();
    }

    public function search(Request $request,$tab){
        //  dd($tab,$request);
        $serch=$request->only(['searching']);

        if($tab =='list')
         return view('posts.index',['posts'=>Post::whereHas('user',function($q) use($serch)
        {$q->where('name','like','%'.$serch['searching'].'%');})
            ->orWhere('title','like','%'.$serch['searching'].'%')
            ->with('user')
            ->get(),
            'tab'=>'list',
            'mostCommented'=>Post::mostCommented()->get(),
            'mostUserPost'=>User::mostUserPost()->get(),
            'mostUserActive'=>User::mostUserActive()->get(),
            ]);


        // if($tab =='archive') return view('posts.index',['posts'=>Post::onlyTrashed()->withCount('comments')->whereHas('user',function($q) use($serch){$q->where('name','like','%'.$serch['searching'].'%');})->onlyTrashed()->orderBy('updated_at','desc')->get(),'tab'=>'archive']);
        // if($tab =='all') return view('posts.index',['posts'=>Post::withTrashed()->withCount('comments')->whereHas('user',function($q) use($serch){$q->where('name','like','%'.$serch['searching'].'%');})->orWhere('title','like','%'.$serch['searching'].'%')->orderBy('updated_at','desc')->get(),'tab'=>'all']);

    }



}
