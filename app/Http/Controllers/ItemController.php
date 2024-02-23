<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ItemFormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
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
        //検索カテゴリーが入力された＝$desiredType
        $desiredType = $request->input('type');
        $keyword = $request->input('keyword');
        //コンフィグのカテゴリーを$typesと定義。
        $types = config('category');
        $query = Items::query();
        // キーワードとカテゴリーで検索された場合
        if ($desiredType && $keyword) {
            $query->where('type', $desiredType)
                ->where(function ($query) use ($keyword) {
                    $query->where('name', 'LIKE', "%$keyword%")
                        ->orWhere('detail', 'LIKE', "%$keyword%");
                });
            // 検索条件・カテゴリー選択された場合
        } else if ($desiredType) {
            //typeカラムから検索する
            $query->where('type', $desiredType);
            // キーワード検索のみされた場合
        } else if ($keyword) {
            $query->where(function ($query) use ($keyword) {
                $query->where('name', 'LIKE', "%$keyword%")
                    ->orWhere('detail', 'LIKE', "%$keyword%");
            });
        }
        //クエリの結果をidの昇順から10件まで表示する。
        $data = $query->orderBy('id', 'asc')->paginate(10);

        $items = Items::orderBy('id', 'asc')->get();
        return view('item.index', [
            'items' => $items,
            'keyword' => $keyword,
            'types' => $types,
            'data' => $data,
            'desiredType' => $desiredType,
        ]);
    }
    /**
     * 商品登録画面表示
     */
    public function add()
    {
        //設定のカテゴリー名
        $types = config('category');
        return view('item.add', [
            'types' => $types,
        ]);
    }

    /**
     * 商品登録確認画面
     */
    public function confirm(ItemFormRequest $request)
    {
        $types = config('category');
        $image = "";
        $inputs = $request->except(["image"]);

        // フォームの入力データをセッションに保存
        $request->session()->put("form_data", $inputs);
        // 画像もある場合もセッションに保存
        if ($request->hasFile("image")) {
            // $image = images/_____.jpeg 
            $image = $request->file("image")->store("images", "public");
            $request->session()->put("image", $image);
        }else
        {
            $image = null;
        }

        return view('item.confirm', [
            'inputs' => $inputs, "image" => $image, 'types' => $types
        ]);
    }


    /**
     * 商品登録
     */
    public function store(Request $request)
    {
        // セッションからデータを取得
        $inputs = $request->session()->get('form_data');
        $image = $request->session()->get('image');

        if ($request->has('back')) {
            $request->session()->forget(["form_data", "image"]);
            return Redirect::route('items.add')->withInput($inputs);
        }

        // データーベースに保存
        $item = new Items();
        $item->fill($inputs);
        $item->user_id =  Auth::user()->id;
        $item->image = $image;
        $item->save();

        // セッションからデータを削除
        $request->session()->forget(["form_data", "image"]);

        // 商品一覧画面に遷移
        return redirect()->route('items.index');
    }

    /**
     * 商品編集画面の表示
     * 
     */
    public function itemview(Request $request, $id)
    {
        $item = Items::findOrFail($id);
        // 商品編集画面を表示する
        return view('item.edit', [
            'item' => $item,
        ]);
    }

    /**
     * 商品編集確認画面
     */
    public function editConfirm(ItemFormRequest $request,$id)
    {
        $types = config('category');
        // itemsテーブルからID情報を取り出し、それを$itemとする
        $item = Items::findOrFail($id);
        $oldImage=$item->image;
        $inputs = $request->except(["image"]);

        // フォームの入力データをセッションに保存
        $request->session()->put("form_data", $inputs);
        $image = null;
        // 画像もある場合もセッションに保存
        if ($request->hasFile("image")) {
            // $image = images/_____.jpeg 
            $image = $request->file("image")->store("images", "public");
            $request->session()->put("image", $image);
            //新たに、アップロードされた画像
            $item->image = $image;
    //下記はこのやり方もあるでメモとして残しておきたいと思います。
        // } elseif ($request->has('delete_image')) {
        //     // 画像削除ボタンが押された場合
        //     Storage::delete('public/' . $item->image);
        //     $item->image = null;
        }else{
            $request->session()->put("image", $oldImage);
        }
        
        // dd($item->image);
        return view('item.editConfirm', [
            'inputs' => $inputs, "image" => $image, 'types' => $types,'item'=>$item,'oldImage'=>$oldImage,
        ]);
    }

    /** 商品編集
     * @param Request $request
     * @param int $item 商品ID
     * @return view|redirect 商品編集画面または商品一覧画面へのリダイレクトレスポンス
     */
    public function edit(Request $request, $id)
    {
        $item = Items::findOrFail($id);
        $inputs = $request->session()->get('form_data');
        $image = $request->session()->get('image');
        if ($request->has('back')) {
            $request->session()->forget(["form_data", "image"]);
            return Redirect::route('items.edit',['id'=>$item->id])->withInput($inputs);
        }
        // データーベースに保存
        $item->fill($inputs);
        $item->image = $image;
        $item->save();
        // セッションからデータを削除
        $request->session()->forget(["form_data", "image"]);
        // 商品編集画面に戻る
        return redirect()->route('items.edit', ['id' => $id]);
    }

    /**
     * 商品登録の削除
     * 
     */
    public function delete(Request $request, $id)
    {
        // 該当の$itemを消去して商品一覧にリダイレクトする
        $item = Items::findOrFail($id);
        $item->delete();
        return redirect('/items');
    }

    /***
     * 登録画像の削除
     */
    public function deleteImage($id)
    {
        // 該当の$itemを取得
        $item = Items::findOrFail($id);

        // 画像が登録されている場合は削除する
        if ($item->image) {
            Storage::delete('public/' . $item->image);
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
        $keyword = $request->input('keyword');
        //コンフィグのカテゴリーを$typesと定義。
        $types = config('category');
        $query = Items::query();
        // キーワードとカテゴリーで検索された場合
        if ($desiredType && $keyword) {
            $query->where('type', $desiredType)
                ->where(function ($query) use ($keyword) {
                    $query->where('name', 'LIKE', "%$keyword%")
                        ->orWhere('detail', 'LIKE', "%$keyword%");
                });
            // 検索条件・カテゴリー選択された場合
        } else if ($desiredType) {
            //typeカラムから検索する
            $query->where('type', $desiredType);
            // キーワード検索のみされた場合
        } else if ($keyword) {
            $query->where(function ($query) use ($keyword) {
                $query->where('name', 'LIKE', "%$keyword%")
                    ->orWhere('detail', 'LIKE', "%$keyword%");
            });
        }
        //クエリの結果をidの昇順から10件まで表示する。
        $data = $query->orderBy('id', 'asc')->paginate(10);
        //itemsテーブルを全て表示する。
        $items = Items::orderBy('id', 'asc')->get();
        return view('item.search', [
            'items' => $items,
            'keyword' => $keyword,
            'types' => $types,
            'data' => $data,
            'desiredType' => $desiredType,
        ]);
    }
    /**
     * 商品詳細画面
     */
    public function detail(Request $request, $id)
    {
        $types = config('category');
        $item = Items::findOrFail($id);
        $imagePath = $request->file('image');
        // 商品編集画面を表示する
        return view('item.detail', [
            'item' => $item,
            'imagePath' => $imagePath,
            'types' => $types,
        ]);
    }
}
