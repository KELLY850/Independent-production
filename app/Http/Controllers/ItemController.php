<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Items;

class ItemController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * 商品管理
     */
    public function index(Request $request)
    {
        $items = Items::paginate(10);
        return view('item.index',[
            'items'=>$items,
        ]);
    }


    /**
     * 商品登録
     */
    public function add(Request $request)
    {
        // 初期値を設定空
        $desiredType = '';
        //設定のカテゴリー名
        $types=config('category');
        // POSTリクエストのとき
        if ($request->isMethod('post'))
        {
            // バリデーション
            $this->validate($request, [
                'name' => 'required|max:100',
                'detail' => 'max:1000',
                'image' => 'image','mimes:jpeg,png,jpg,gif',
            ]);
            //入力されたカテゴリーの値を定義
            $desiredType = $request->input('type');
            //画像を保存する処理
            //もしも画像ファイルがあった場合には
            if($request->hasFile('image'))
            {
                //画像の既存名をそのまま＄imagePathへそのまま格納
                $imagePath = $request->file('image')->getClientOriginalName();
                //ストレージのimageフォルダに保存する
                $request->file('image')->storeAs('public/image/', $imagePath);
            }else{
                //あるいは、ファイルはない。
                $imagePath = null;
            }

            // 商品登録
            $items = Items::create([
                //ログインユーザーIDと同一
                'user_id' => Auth::user()->id,
                'name' => $request->name,
                //リクエストのカテゴリーの値
                'type' => $desiredType,
                'price' => $request->price,
                'status' => $request->status,
                'detail' => $request->detail,
                'image' => $imagePath,
            ]);
            // 商品一覧画面に遷移
            return redirect()->route('items.index');
        }
        return view('item.add',[
            'types'=>$types,
        ]);
    }   
    //編集画面
    /**
     * @param Request $request
     * @param int $item 商品ID
     * @return view|redirect 商品編集画面または商品一覧画面へのリダイレクトレスポンス
     */
    public function edit(Request $request,$id)
    {
        // POSTリクエストの場合の処理
        if ($request->isMethod('post')) 
        {
            // バリデーション
            $this->validate($request, [
                'name' => 'required|max:100',
                'detail' => 'max:1000',
                'image' => 'image','mimes:jpeg,png,jpg,gif',
            ]);
            // itemsテーブルからID情報を取り出し、それを$itemとする
            $item = Items::findOrFail($id);

            //画像を保存する処理
            //もしも画像が入っていたら
            if($request->hasFile('image'))
            {
                // 過去登録した商品画像のパスを取得
                $oldImagePath = $item->image;
                // 新しく入力された画像ファイル名を格納
                $imagePath = $request->file('image')->getClientOriginalName();
                //ストレージファイルに保存
                $request->file('image')->storeAs('public/image/', $imagePath);
                //もしも、過去の画像があった場合には、
                if ($oldImagePath) 
                {
                    //ストレージから削除する。
                    Storage::delete($oldImagePath);
                }
                //新たに、アップロードされた画像
                $item->image = $imagePath;
            }elseif ($request->has('delete_image')) 
            {
                // 画像削除ボタンが押された場合
                Storage::delete('public/image/' . $item->image);
                $item->image = null;
            }           
            // $itemのname,type,detailについてリクエストが入ったらそれぞれ
            // 新たに各カラムに入る
            $item->name = $request->input('name');
            $item->type = $request->input('type');
            $item->price = $request->input('price');
            $item->status = $request->input('status');
            $item->detail = $request->input('detail');
            // 上記、新たに入った内容の（既存の情報と比較して）保存を行う
            $item->save();
            // 商品編集画面に戻る
            return redirect()->route('items.edit', ['id' => $id]);
        // デリートリクエストの場合
        }elseif($request->isMethod('delete'))
        {
            // 該当の$itemを消去して商品一覧にリダイレクトする
            $item = Items::findOrFail($id);
            $item->delete();
            return redirect('/items');
        }

        // GETリクエストの場合の処理       
        $item = Items::findOrFail($id);
        $imagePath = $request->file('image');
        // 商品編集画面を表示する
        return view('item.edit', [
            'item' => $item,
            'imagePath' => $imagePath,
        ]);
    }
    /***
     * 登録画像の削除
     */
     public function deleteImage($id)
    {
        // 該当の$itemを取得
        $item = Items::findOrFail($id);
                    
        // 画像が登録されている場合は削除する
        if ($item->image)
        {
           Storage::delete('public/image/' . $item->image);
            $item->image = null;
            $item->save();
        }

        // 商品編集画面にリダイレクトする
        return redirect()->route('items.edit', ['id' => $id]);
    }

         /**
     * 商品検索
     */
    public function search(Request $request)
    {
        //検索カテゴリーが入力された＝$desiredType
        $desiredType = $request->input('type');
        $keyword=$request->input('keyword');
        //コンフィグのカテゴリーを$typesと定義。
        $types=config('category');
        $query = items::query();
        // キーワードとカテゴリーで検索された場合
        if( $desiredType && $keyword)
        {
            $query->where('type', $desiredType)
            ->where(function ($query) use ($keyword)
            {
                $query->where('name', 'LIKE', "%$keyword%")
                ->orWhere('detail', 'LIKE', "%$keyword%");
            });
        // 検索条件・カテゴリー選択された場合
        }else if($desiredType)
        {
            //typeカラムから検索する
            $query->where('type',$desiredType);
            // キーワード検索のみされた場合
        }else if($keyword)
        {
            $query->where(function($query) use ($keyword)
            {
                $query->where('name','LIKE',"%$keyword%")
                ->orWhere('detail','LIKE',"%$keyword%");
    
            });
        }
        //クエリの結果をidの昇順から10件まで表示する。
        $data = $query->orderBy('id', 'asc')->paginate(10);
        //itemsテーブルを全て表示する。
        $items = items::orderBy('id', 'asc')->get();
        return view('item.search',[
            'items'=>$items,
            'keyword'=>$keyword,
            'types'=>$types,
            'data'=>$data,
        ]);
    }
    /**
     * 商品詳細画面
     */
    public function detail(Request $request,$id)
    {
        $types=config('category');
        $item = Items::findOrFail($id);
        $imagePath = $request->file('image');
        // 商品編集画面を表示する
        return view('item.detail', [
            'item' => $item,
            'imagePath' => $imagePath,
            'types'=>$types,
        ]);
    }


}
