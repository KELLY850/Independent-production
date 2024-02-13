<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Items;

class ItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Items::create([
            'name'=>'歩行器',
            'type'=>'1',
            'price'=>'500',
            'detail'=>'歩行器です',
            'user_id'=>'1',
        ]);
        Items::create([
            'name'=>'杖',
            'type'=>'2',
            'price'=>'500',
            'detail'=>'杖です',
            'user_id' => '2',
        ]);
        Items::create([
            'name'=>'車椅子',
            'type'=>'3',
            'price'=>'500',
            'detail'=>'車椅子です',
            'user_id' => '3',
        ]);
        Items::create([
            'name'=>'手すり',
            'type'=>'4',
            'price'=>'500',
            'detail'=>'手すりです',
            'user_id' => '4',
        ]);
        Items::create([
            'name'=>'電動ベッド',
            'type'=>'5',
            'price'=>'500',
            'detail'=>'電動ベッドです',
            'user_id' => '5',

        ]);


    }
}
