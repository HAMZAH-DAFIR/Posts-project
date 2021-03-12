<?php

namespace App\Models;

use App\Scopes\AdminGlobascope;
use App\Scopes\LatestScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

class Post extends Model
{
    use HasFactory;
    // delete logic
    use SoftDeletes;

    protected $fillable=['title','content','user_id'];
    protected $hidden=['deleted_at','created_at','user_id'];
    //--------------relationship---------------------
    public function comments(){
        return $this->morphMany(Comment::class,'commentable');
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function picture(){
        return $this->morphOne(Image::class,'imageable');
    }
    public function tags(){
        return $this->morphToMany(Tag::class,'taggable')->withTimestamps();
    }
    //------------- local scopes-----------------
    public function scopeMostCommented(Builder $query){
        return $this->withCount('comments')->orderBy('comments_count','desc')->take(5);
    }


    //delete comments before delete post
    public static function boot(){
        static::addGlobalScope(new AdminGlobascope);
        parent::boot();
        static::addGlobalScope(new LatestScope);




    }
}
