<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Items;


class TypeController extends Controller
{
    //歩行器の商品ページの作成
    public function index(Request $request)
    {
        $items = Items::where('type', 1)
        ->where('status', 'active')
        ->paginate(8);

        return view('type.type1', [
        'items' => $items
        ]);
    }
    //杖の商品ページの作成
    public function index2(Request $request)
    {
        $items = Items::where('type', 2)
        ->where('status', 'active')
        ->paginate(8);

        return view('type.type2', [
        'items' => $items
        ]);
    }
    //車椅子の商品ページの作成
    public function index3(Request $request)
    {
        $items = Items::where('type', 3)
        ->where('status', 'active')
        ->paginate(8);

        return view('type.type3', [
        'items' => $items
        ]);
    }
    //手すりの商品ページの作成
    public function index4(Request $request)
    {
        $items = Items::where('type', 4)
        ->where('status', 'active')
        ->paginate(8);

        return view('type.type4', [
        'items' => $items
        ]);
    }
    //電動ベッドの商品ページの作成
    public function index5(Request $request)
    {
        $items = Items::where('type', 5)
        ->where('status', 'active')
        ->paginate(8);

        return view('type.type5', [
        'items' => $items
        ]);
    }
    public function detail(Request $request,$id)
    {
        $types=config('category');
        $item = Items::findOrFail($id);
        $imagePath = $request->file('image');
        // 商品編集画面を表示する
        return view('type.detail', [
            'item' => $item,
            'imagePath' => $imagePath,
            'types'=>$types,
        ]);

    }
}
