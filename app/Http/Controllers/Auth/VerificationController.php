<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\VerifiesEmails;

class VerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be re-sent if the user didn't receive the original email message.
    |
    */

    use VerifiesEmails;

    /**
     * Where to redirect users after verification.
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
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }
}


// 勉強のために、すみませんコードの意味をここで直接書きます。
// Eメールの確認を処理するためのコントローラーです。具体的には、
// ユーザーがアプリケーションに新規登録した直後に送信された確認メールの処理や、
// ユーザーが確認メールを受信しなかった場合の再送信などを担当します。
// １、VerifiesEmails トレイトを使用して、Eメールの確認に関連する処理を実装します。
// このトレイトには、確認メールの送信、確認リンクのクリック時の処理、確認が完了した後のリダイレクトなどが含まれています。
// ２、protected $redirectTo プロパティは、確認が完了した後にユーザーを
// リダイレクトする先のURLを指定します。通常は、RouteServiceProvider::HOME 定数に定義されたホームページのURLにリダイレクトされます。
// ３、__construct() メソッド内の $this->middleware() メソッドは、コントローラーの
// 各アクションに対してミドルウェアを適用します。具体的には、auth ミドルウェアはユーザーの認証を確認し、
// signed ミドルウェアは署名付きURLのみを処理します（通常、確認メールのリンクは署名付きURLとして生成されます）。
// throttle ミドルウェアは、同じアクションに対するリクエストの数を制限します。