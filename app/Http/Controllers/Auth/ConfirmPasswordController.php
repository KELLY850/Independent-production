<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ConfirmsPasswords;

class ConfirmPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Confirm Password Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password confirmations and
    | uses a simple trait to include the behavior. You're free to explore
    | this trait and override any functions that require customization.
    |
    */

    use ConfirmsPasswords;

    /**
     * Where to redirect users when the intended url fails.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
}


// このコードは、パスワードの確認（再入力）に関連するコントローラーの一部です。以下は、各部分の説明です。
// use ConfirmsPasswords;: ConfirmsPasswords トレイトを使用することを宣言しています。
// このトレイトには、パスワードの確認に関連するメソッドが含まれています。
// 例えば、パスワード確認画面の表示やパスワード確認処理の実行などが含まれます。
// protected $redirectTo = RouteServiceProvider::HOME;: パスワード確認後に
// ユーザーをリダイレクトする先のURLを指定しています。デフォルトでは
//  RouteServiceProvider::HOME という定数が使用されており、これは routes/web.php 
//  ファイル内で定義されているデフォルトのリダイレクト先を示します。
// public function __construct(): コントローラーのコンストラクターです。
// この中で、コントローラーのミドルウェアや依存関係の設定などが行われます。
// $this->middleware('auth');: コンストラクター内で設定されているミドルウェアです。
// auth ミドルウェアは、認証済みのユーザーのみがアクセスを許可するためのものです。
// つまり、パスワード確認画面にアクセスするには、ユーザーが認証されている必要があります。