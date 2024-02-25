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
    /**　管理者権限のみ
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
     * @param Request $request
     * @param string　$desiredType 検索時に入力されたカテゴリー
     * @param string $keyword 検索時に入力されたキーワード
     * @param array $types コンフィグカテゴリー
     * 
     */
    public function index(Request $request)
    {
        //検索カテゴリーが入力された＝$desiredType
        $desiredType = $request->input('type');
        //検索キーワードが入力された　＝　＄keyword
        $keyword = $request->input('keyword');
        //コンフィグのカテゴリーを$typesと定義。
        $types = config('category');
        $query = Items::query();
        // キーワードとカテゴリーで検索された場合
        if ($desiredType && $keyword) {
            //$desredTypeはItemsモデルのtypeカラムで
            $query->where('type', $desiredType)
            //$keywordを使って、nameとdetailカラムから＄keywordに似た言葉を検索する。
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
            //$keywordを使って、nameとdetailカラムから＄keywordに似た言葉を検索する。
            $query->where(function ($query) use ($keyword) {
                $query->where('name', 'LIKE', "%$keyword%")
                    ->orWhere('detail', 'LIKE', "%$keyword%");
            });
        }
        //クエリの結果をidの昇順から10件まで表示する。
        $data = $query->orderBy('id', 'asc')->paginate(10);
        //ItemsモデルからIDを昇順で並べる。
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
     * @return view
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
     * @param ItemFormRequest $request バリデーションあり
     * @return view
     */
    public function confirm(ItemFormRequest $request)
    {
        //コンフィグのcategoryディレクトリの配列を＄typesとする
        $types = config('category');
        //入力されたフォームから（image）nameを除外した内容を$inputsとする。
        $inputs = $request->except(["image"]);
        // フォームの入力データをセッションに保存($inputs(値)でform_data(キー)として保存)
        $request->session()->put("form_data", $inputs);
        //$imageは初期値空。
        $image = "";
        // image・画像もある場合、
        if ($request->hasFile("image")) {
            // $image は挿入されたimage(file nameの)をpublicディレクトリのimagesに保存する。
            $image = $request->file("image")->store("images", "public");
            //一時的に＄image（値）のimage(キー)を保存する
            $request->session()->put("image", $image);
        } else {
            //あるいは、＄imageはnull
            $image = null;
        }

        return view('item.confirm', [
            'inputs' => $inputs, "image" => $image, 'types' => $types
        ]);
    }


    /**
     * 商品登録
     * @param Request $request
     * 
     */
    public function store(Request $request)
    {
        // セッションから画像情報以外の入力情報を取得
        $inputs = $request->session()->get('form_data');
        //セッションから画像情報を取得
        $image = $request->session()->get('image');
        //もしも、「back(name)」がリクエストされたら、
        if ($request->has('back')) {
            //セッションのform_dataとimageを削除する。
            $request->session()->forget(["form_data", "image"]);
            //商品登録に遷移しても、$inputsの情報は保持しておく（フォームに入力されている）。
            return Redirect::route('items.add')->withInput($inputs);
        }

        //Itemsモデルの新しいインスタンスを作成。
        //新しいインスタンスを作成することで、新しいレコードをデータベースに挿入する準備をする。
        $item = new Items();
        //モデルのfillableプロパティに指定されたフィールドに対して、入力データを一括で代入するメソッド.
        //$inputsは、フォームから送信されたデータを含む連想配列で、このメソッドによって、$itemの各属性に対応するフォームの入力値が自動的に代入される。
        $item->fill($inputs);
        //ログインしているユーザーのIDを、作成されるアイテムのuser_id属性に代入しています
        $item->user_id =  Auth::user()->id;
        $item->image = $image;
        //データベースに保存
        $item->save();

        // セッションから"form_data", "image"のデータを削除
        $request->session()->forget(["form_data", "image"]);
        // 商品一覧画面に遷移
        return redirect()->route('items.index')->with("message", "登録が完了しました。");
    }

    /**
     * 商品編集画面の表示
     * @param Request $request
     * @return view
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
     * @param ItemFormRequest $request
     * @param int $item 商品ID
     * @return view
     */
    public function editConfirm(ItemFormRequest $request, $id)
    {
        //configのcategoryディレクトリを$types
        $types = config('category');
        // itemsテーブルからID情報を取り出し、それを$itemとする
        $item = Items::findOrFail($id);
        //入力リクエストからimageは除外したものを$inputsとする
        $inputs = $request->except(["image"]);
        // フォームの入力データをセッションに一時的保存（＄inputs(値)でform_dat（キー)として保存)
        $request->session()->put("form_data", $inputs);
        //商品が元々挿入されていた画像を＄oldImageとする
        $oldImage = $item->image;
        //$iamgeはnull
        $image = null;
        // image・画像がある場合には、
        if ($request->hasFile("image")) {
            // $image = imageファイルをpublicのimagesディレクトリに保存する
            $image = $request->file("image")->store("images", "public");
            //セッションに＄image（値）・image（キー）で一時的に保存する。
            $request->session()->put("image", $image);
            //新たに、アップロードされた画像が最新の画像となる。
            $item->image = $image;
                                            //下記はこのやり方もあるでメモとして残しておきたいと思います。
                                            // } elseif ($request->has('delete_image')) {
                                            //     // 画像削除ボタンが押された場合
                                            //     Storage::delete('public/' . $item->image);
                                            //     $item->image = null;
        } else {
            //あるいは、セッションに元からあった画像・imageを一時的に保存する。
            $request->session()->put("image", $oldImage);
        }
                                            //勉強でこのように確認していました。 dd($item->image);
        return view('item.editConfirm', [
            'inputs' => $inputs, "image" => $image, 'types' => $types, 'item' => $item, 'oldImage' => $oldImage,
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
        //セッションから入力内容を取得。
        $inputs = $request->session()->get('form_data');
        //セッションから画像情報を取得。
        $image = $request->session()->get('image');
        //もしも「back」リクエストが入ったら
        if ($request->has('back')) {
            //セッションから画像情報と入力内容を削除する。
            $request->session()->forget(["form_data", "image"]);
            //商品編集画面にリダイレクトするが、その際には、入力内容を保持する。
            return Redirect::route('items.edit', ['id' => $item->id])->withInput($inputs);
        }
        //モデルのfillableプロパティに指定されたフィールドに対して、入力データを一括で代入するメソッド.
        //$inputsは、フォームから送信されたデータを含む連想配列で、このメソッドによって、$itemの各属性に対応するフォームの入力値が自動的に代入される。
        $item->fill($inputs);
        //画像情報を新たに＄item->imageとして変更
        $item->image = $image;
        //編集内容を保存
        $item->save();
        // セッションからデータを削除
        $request->session()->forget(["form_data", "image"]);
        // 商品編集画面に戻る
        return redirect()->route('items.edit', ['id' => $id])->with("message", "編集が完了しました。");
    }

    /**
     * 商品登録の削除
     * @param Request $request
     * @param int ＄item 商品ID
     * 
     */
    public function delete(Request $request, $id)
    {
        // 該当の$itemを消去して商品一覧にリダイレクトする
        $item = Items::findOrFail($id);
        $item->delete();
        return redirect('/items')->with("message", "削除できました。");
    }

    /**
     * 登録画像の削除
     * @param　 int $item 商品ID
     * @return view|Redairect　商品編集画面に戻る。
     */
    public function deleteImage($id)
    {
        // 該当の$itemを取得
        $item = Items::findOrFail($id);

        // 画像が登録されている場合
        if ($item->image) {
            //publicディレクトリから該当の画像を削除する。
            Storage::delete('public/' . $item->image);
            //そうなったら＄item->imageはnullになる。
            $item->image = null;
            //その内容を保存する。
            $item->save();
        }

        // 商品編集画面にリダイレクトする
        return redirect()->route('items.edit', ['id' => $id]);
    }

    /**
     * 商品検索
     * @param Request $request
     * @return view
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
     * @param int $item 商品ID
     * @return view  
     */
    public function detail($id)
    {
        $types = config('category');
        $item = Items::findOrFail($id);
        // 商品編集画面を表示する
        return view('item.detail', [
            'item' => $item,
            'types' => $types,
        ]);
    }
}
