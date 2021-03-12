<?php

namespace App\Models;

use Illuminate\Http\Request;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Storage;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable,HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'email_verified_at'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    //-----------------Relattionship between models --------------------------------------
    public function posts(){
        return $this->hasMany(Post::class);
    }
    public function comments(){
        return $this->morphMany(Comment::class,'commentable');
    }
    public function image(){
        return $this->morphOne(Image::class,'imageable');
    }
    //-------------------------------local Scopes ----------------------------------------------------------------
    public function scopemostUserPost(Builder $query){
        return $query->withCount('posts')
        ->with('image')
        ->orderBy('posts_count','desc')->take(5);
    }
    public function scopeMostUserActive(Builder $query){
        return $query->withCount(['posts'=>function(Builder $query){
           $query->whereBetween(static::CREATED_AT,[now()->subMonths(1),now()]);
        }])
        ->with('image')
        ->having('posts_count','>',10)
        ->orderBy('posts_count','desc')
        ->take(5);
    }
    public static function boot(){

        parent::boot();
        // static::created(function(User $user){
        //     // dd($user);
        //     if(isset($data['picture'])){

        //         $path=Storage::putFile('posts',$data['picture']);
        //         // $data['picture']->store('thumbnails');
        //         dd($path);
        //         Image::create(['path'=> $path,'user_id'=>$user->id]);

        //      }
        // });

    }
}
