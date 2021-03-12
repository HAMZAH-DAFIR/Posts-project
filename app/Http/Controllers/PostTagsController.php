<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class PostTagsController extends Controller
{
    public function index($id){
        //  dd(Tag::find($id)->posts()->with('user'));
        return view('posts.index',
        ['posts'=>Tag::find($id)->posts()->with(['user','tags'])->get()]);
    }
}
