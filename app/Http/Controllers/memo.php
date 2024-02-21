
<!-- こういうやりかたもある、というのでメモさせてください。 -->

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


 <!-- 編集更新内容             -->
     // itemsテーブルからID情報を取り出し、それを$itemとする
        $item = Items::findOrFail($id);
        //画像を保存する処理
        //もしも画像が入っていたら
        if ($request->hasFile('image')) {
            // 過去登録した商品画像のパスを取得
            $oldImagePath = $item->image;
            // 新しく入力された画像ファイル名を格納
            $imagePath = $request->file('image')->getClientOriginalName();
            //ストレージファイルに保存
            $request->file('image')->storeAs('public/image/', $imagePath);
            //もしも、過去の画像があった場合には、
            if ($oldImagePath) {
                //ストレージから削除する。
                Storage::delete($oldImagePath);
            }
            //新たに、アップロードされた画像
            $item->image = $imagePath;
        } elseif ($request->has('delete_image')) {
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
    }
