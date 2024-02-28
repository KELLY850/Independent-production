<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {        
        
        User::create([
            'name'=>'管理者',
            'email'=>'test1@co.jp',
            'name_katakana'=>'カンリシャ',
            'role'=>'admin',
            'password'=>'1A2s1a2S'
        ]);
        // Users::create([
        //     'name'=>'社員2',
        //     'email'=>'test2@co.jp',
        //     'password'=>'22222222'
        // ]);
        // Users::create([
        //     'name'=>'社員3',
        //     'email'=>'test3@co.jp',
        //     'password'=>'33333333'
        // ]);
        // Users::create([
        //     'name'=>'社員4',
        //     'email'=>'test4@co.jp',
        //     'password'=>'44444444'
        // ]);
        // Users::create([
        //     'name'=>'社員5',
        //     'email'=>'test5@co.jp',
        //     'password'=>'55555555'
        // ]);
        // User::factory()->count(10)->create();

    }
}
