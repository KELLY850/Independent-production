<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use App\Http\Requests\UserFormRequest;
use App\Models\User;


class UserController extends Controller
{
    //管理者権限のみ
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * アカウント一覧表示・検索機能付き
     * @param Request $request
     * @return view
     */
    public function list2(Request $request)
    {
        //選択した検索カテゴリーを＄category
        $category = $request -> input('category');
        //入力した検索キーワードを$keyword
        $keyword = $request -> input('keyword');
        //入力した$keywordのの
        $keywordWithoutSpace = str_replace(' ', '', $keyword);
        $query = User::query();

        if(!empty($category) && !empty($keyword))
        {
            if ($category === 'user') {
                $query->whereNull('role');
            } else {
                $query->where('role', $category);
            }
            $query->where(function ($query) use ($keyword,$keywordWithoutSpace)
            {
                $query->where('name','LIKE',"%$keyword%")
                ->orWhere('name_katakana','LIKE',"%$keyword%")
                ->orWhere('name', 'LIKE', "%$keywordWithoutSpace%")
                ->orWhere('name_katakana', 'LIKE', "%$keywordWithoutSpace%");
            });
        }else{
            if(!empty($category))
            {
                if($category === 'user')
                {
                    $query->whereNULL('role');
                }else{
                    $query->where('role',$category);
                }
            }
            if(!empty($keyword))
            {
                $query->where(function($query) use ($keyword,$keywordWithoutSpace)
                {
                    $query->where('name','LIKE',"%$keyword")
                    ->orWhere('name_katakana','LIKE',"%$keyword%")
                    ->orWhere('name', 'LIKE', "%$keywordWithoutSpace%")
                    ->orWhere('name_katakana', 'LIKE', "%$keywordWithoutSpace%");
                });
            }
            // dd($query);

        }
        // dd(old('category'));
        // dd(session()->all());
        $data = $query->orderBy('id','asc')->paginate(5);

        // 全てのユーザーを表示
        $users = User::orderBy('id', 'asc')->paginate(5);
        return view('user.admin', [
            'users' => $users,
            'category' => $category,
            'keyword' => $keyword,
            'data' => $data,
        ]);
    }

    /**
     * アカウント詳細画面表示
     */
    public function edit(Request $request,$id)
    {
        $user = User::findOrfail($id);
        return view('user.edit',[
            'user' => $user,
        ]);
    }
    
    /**
     * アカウント編集
     */
    public function update(Request $request,$id)
    {
        $user = User::findOrfail($id);
        $oldEmail = $user->email;
        $newEmail = $request->input('email');
        if($newEmail !== $oldEmail)
        {
            $request->validate([
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            ]);
        }
        $request->validate([
            'name' => ['required', 'string', 'max:255','regex:/^[^\d]+$/u'],
            'name_katakana' =>['required','string','max:255', 'regex:/^[ァ-ヶー\s]+$/u'],
        ]);
        $user->name = $request->input('name');
        $user->name_katakana = $request->input('name_katakana');
        $user->email = $newEmail;
        $user->role = $request->input('role');
        // 上記、新たに入った内容の（既存の情報と比較して）保存を行う
        $user->save();
        // 商品編集画面に戻る
        return redirect()->route('users.edit', ['id' => $id])->with("message","編集が完了しました。");
    }
           /**
     * 商品登録の削除
     * 
     */
    public function delete(Request $request,$id)
    {
        // 該当の$itemを消去して商品一覧にリダイレクトする
        $user = User::findOrFail($id);
        $user->delete();
        return redirect('/users/admin');
    }

    
}



