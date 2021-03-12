<?php
namespace App\Http\ViewComposer;

use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class Activity {


    public function compose(View $view){

        $mostCommented=Cache::remember('mostCommented',30, function () {
            return Post::mostCommented()->get();
        });
        $mostUserPost=Cache::remember('mostUserPost',30,function(){
            return User::mostUserPost()->get();
        });
        $mostUserActive=Cache::remember('mostUserActive',30,function(){
            return User::mostUserActive()->get();
        });

        $view->with([
        'mostCommented'=>$mostCommented,
        'mostUserPost'=>$mostUserPost,
        'mostUserActive'=>$mostUserActive
        ]);

    }
}
