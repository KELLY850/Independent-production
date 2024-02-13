<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
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
        $this->middleware('guest')->except('logout');
    }
}


// $this->middleware('guest')->except('logout');: コンストラクター内で設定されている
// ミドルウェアです。guest ミドルウェアは、ユーザーがログインしていない場合にのみアクセスを
// 許可するためのものです。except メソッドは、logout メソッドを除外しています。
// つまり、ログアウト時には guest ミドルウェアが適用されません。これにより、ログインしていない
// ユーザーのみがログインフォームやログイン処理にアクセスできるようになります。

