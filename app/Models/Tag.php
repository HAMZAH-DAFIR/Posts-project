<?php

namespace App\Models;

use App\Scopes\AdminGlobascope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Model
{
    use HasFactory;
    // use SoftDeletes;
    protected $fillable=['name'];
    public function posts(){
        return $this->morphedByMany(Post::class,'taggable')->withTimestamps();
    }
    public function comments(){
        return $this->morphedByMany(Comment::class,'taggable')->withTimestamps();
    }
    public static function boot(){
        // static::addGlobalScope(new AdminGlobascope);
        parent::boot();

    }
}
