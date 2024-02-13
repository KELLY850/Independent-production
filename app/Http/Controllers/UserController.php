<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;


class UserController extends Controller
{
    //管理者権限のみ
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index(Request $request)
    {
        // 権限がを持たないユーザーを表示
        $users= User::whereNull('role','')->paginate(10);
        return view('user.nulluser',[
            'users'=>$users,
        ]);
    }
    public function list2(Request $request)
    {
        $category = $request -> input('category');
        $keyword = $request -> input('keyword');
        $katakana = $request -> input('katakana');
        $query = User::query();
        if(!empty($category) && !empty($keyword) && !empty($katakana))
        {
            
        }
        // 全てのユーザーを表示
        $users = User::orderBy('id', 'asc')->paginate(10);

        return view('user.admin', [
            'users' => $users,
        ]);
    }
}


