<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Image;
use Illuminate\Database\Seeder;

class ImageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user= User::all();
        $images=collect(['pic1.jfif','pic2.jfif','pic3.jfif','pic4.jfif','pic5.jfif','pic6.jfif','pic7.jfif','pic8.jfif','pic9.jfif','pic10.jfif']);
        $images->each(function($image) use($user){
            $path=$image->file()->store('posts');
            Image::create(['path'=> $image,'user_id'=>$user->next()->id]);
        });
    }
}
