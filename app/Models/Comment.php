<?php

namespace App\Models;

use App\Scopes\LatestScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

class Comment extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable=['content','user_id'];
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function commentable(){
        return $this->morphTo();
    }
    public function tags(){
        return $this->morphToMany(Tag::class,'taggable')->withTimestamps();
    }
    public function scopeCommentUser(Builder $query){
        return $query->with('user');
    }
    public static function boot(){

        parent::boot();
        static::addGlobalScope(new LatestScope);
        static::creating(function(Comment $comment){
            Cache::forget("show-post-{$comment->commentable->id}");
            Cache::forget('mostUserPost');
        });
        static::deleting(function(Comment $comment){
            Cache::forget("show-post-{$comment->commentable->id}");
            Cache::forget('mostUserPost');
        });
    }
}
