<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $tags=collect(['Sport','Game','Science','Travel','Cars','Book','Naws','Training']);
        $tags->each(function($tag){
            $myTag=new Tag();
            $myTag->name=$tag;
            $myTag->save();
        });

    }
}
