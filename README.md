
# 介護用品管理

## 概要
　このシステムでは、管理者権限を持つアカウントのみ福祉用具の登録及び編集、削除が可能です。
　加えて、アカウント管理もでき、権限の付与・メールアドレス・名前の修正或いは削除ができます。
　また、商品検索機能もあり、管理者権限及び社員権限を持つアカウントのみ福祉用具の検索・詳細画面を
　確認することができます。
　上記は、権限を持つユーザーでのログインが必要になりますが、ログイン不要で公開設定されている
　福祉用具の商品の一覧及び詳細画面を確認することができます。

## 主な機能・画面

* ホーム画面（ログイン不要）
    * 画像カテゴリーからの商品一覧画面
    * 商品詳細画面
* 商品管理画面(管理者権限ログイン要・商品検索機能あり)
    * 商品登録画面
    * 商品登録確認画面
    * 商品編集画面
    * 商品編集確認画面
* 商品検索画面(社員・管理者権限ログイン要)
    * 商品詳細画面（編集機能は無し）
* アカウント管理画面(管理者権限ログイン要・アカウント検索機能あり)
    * アカウント編集画面
* ログイン画面
* 新規登録画面

## 開発環境
    Laravel 10
    PHP 8.2
    MySQL 
    MAMP
    Git Hub
    VsCode

### 設計書
https://drive.google.com/drive/folders/1aCZk72iEbDCth1xvMh8_RXN2cNss7knK?usp=drive_link

### HerokuURL ※Heroku登録削除
[https://welfareequipment-16d0dd36007e.herokuapp.com>](https://welfareequipment-app-348b36d358ae.herokuapp.com/)
* テストアカウント（社員権限）
    * メールアドレス：syain@co.jp
    * パスワード：aaaaaaaa
* テストアカウント（管理者権限）
    * メールアドレス：test@co.jp
    *パスワード：aaaaaaaa

