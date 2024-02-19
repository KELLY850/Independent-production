<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

//ログイン機能
Auth::routes();

//ダッシュボード（ホーム）画面表示・どのユーザーでも遷移可能
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('items')->group(function () 
{
    // 商品管理画面
    Route::get('/', [App\Http\Controllers\ItemController::class, 'index'])->name('items.index')->middleware('admin');
    // 商品検索画面と商品詳細画面・・・管理者権限と一般社員が遷移可能
    Route::middleware(['admin', 'employee'])->group(function () {
        //商品検索画面
        Route::get('/search', [App\Http\Controllers\ItemController::class, 'search'])->name('items.search');
        //商品詳細画面
        Route::get('/search/{id}', [App\Http\Controllers\ItemController::class, 'detail'])->name('items.detail');
    });
    // 商品登録画面と商品編集画面と登録画像削除・・・管理者権限のみ遷移可能
    Route::middleware(['admin'])->group(function () {
        //商品登録画面表示
        Route::get('/add', [App\Http\Controllers\ItemController::class, 'add'])->name('items.add');
        //商品登録
        Route::post('/add', [App\Http\Controllers\ItemController::class, 'store'])->name('items.store'); 
        //登録確認画面
        Route::post('/add/confirm',[App\Http\Controllers\ItemController::class, 'confirm'])->name('items.confirm'); 
        //灯篭内容完了画面
        Route::get('/add/complete', [App\Http\Controllers\ItemController::class, 'complete'])->name('items.complete'); 

        //商品編集画面表示
        Route::get('/edit/{id}', [App\Http\Controllers\ItemController::class, 'itemview'])->name('items.edit');
        //商品編集
        Route::post('/edit/{id}', [App\Http\Controllers\ItemController::class, 'edit'])->name('items.update');
        //商品削除
        Route::post('/{id}/delete', [App\Http\Controllers\ItemController::class, 'delete'])->name('items.delete');
        //登録画像削除
        Route::post('/{id}/delete-image', [App\Http\Controllers\ItemController::class, 'deleteImage'])->name('items.deleteImage');//画像削除
    });    
});

//各カテゴリーの商品をまとめたページを表示・どのユーザーも遷移可能
Route::prefix('types')->group(function()
    {
        //カテゴリーの商品詳細ページを表示
        Route::get('/detail/{id}',[App\Http\Controllers\TypeController::class, 'detail'])->name('types.detail');
        //押し車の（歩行器）のページのみ表示
        Route::get('/1',[App\Http\Controllers\TypeController::class, 'index']);
        //杖のページのみ表示
        Route::get('/2',[App\Http\Controllers\TypeController::class, 'index2']);
        //車椅子のページのみ表示
        Route::get('/3',[App\Http\Controllers\TypeController::class, 'index3']);
        //手すりのページのみ表示
        Route::get('/4',[App\Http\Controllers\TypeController::class, 'index4']);
        //電動ベッドのページのみ表示
        Route::get('/5',[App\Http\Controllers\TypeController::class, 'index5']);
    });

//ユーザー管理画面
Route::prefix('users')->group(function()
    {
        // 管理者権限を持つものだけが遷移可能
        Route::middleware(['admin'])->group(function ()
        {
            //アカウント管理画面
            Route::get('/admin',[App\Http\Controllers\UserController::class, 'list2'])->name('users.admin');
            //一般社員・管理者編集画面
            Route::get('/admin/{id}',[App\Http\Controllers\UserController::class, 'edit'])->name('users.edit');
            //アカウント編集
            Route::post('/admin/{id}',[App\Http\Controllers\UserController::class, 'update'])->name('users.update');
            //アカウント削除
            Route::post('/{id}/delete',[App\Http\Controllers\UserController::class, 'delete'])->name('users.delete');
        });
    });
