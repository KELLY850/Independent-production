
<!-- 商品登録時の内容です -->
            // 初期値を設定空
             $desiredType = '';
            //設定のカテゴリー名
             $types=config('category');
            //入力されたカテゴリーの値を定義
             $desiredType = $request->input('type');
            // 画像を保存する処理
            // もしも画像ファイルがあった場合には
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
