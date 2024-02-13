@extends('adminlte::page')

@section('title', '商品登録')

@section('content_header')
    <h1>商品登録</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-10">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                       @foreach ($errors->all() as $error)
                          <li>{{ $error }}</li>
                       @endforeach
                    </ul>
                </div>
            @endif

            <div class="card card-primary">
                <form method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">名前</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="名前">
                        </div>

                        <div class="form-group">
                            <label for="type">種別</label>
                            <select name="type" id="type" class="form-control">
                                @foreach($types as $key => $type)
                                <option value="{{ $key }}">{{ $type }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="detail">価格</label>
                            <input type="number" class="form-control" id="price" name="price" placeholder="価格" min="0" max="10000000">
                        </div>
                        <div class="form-group">
                            <label for="status">ステータス</label>
                            <select name="status" id="status" class="form-control">
                                <option value="active">公開</option>
                                <option value="inactive">非公開</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="detail">詳細</label>
                            <textarea class="form-control" name="detail" id="detail" placeholder="詳細を入力してください">
                            </textarea>
                        </div>
                        <div class="image-upload">
                            <label for="detail">画像</label><br>
                            <input type="file" id="file" name="image" placeholder="画像ファイルを選択してください">
                        </div>

                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">登録</button>
                    </div>
                </form>
                <div class="card-footer">
                    <button type="button" id="go-back" class="btn btn-primary">戻る</button>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
@stop

@section('js')
    <script>
        const back=document.getElementById("go-back");
        back.addEventListener("click",()=>{
            window.history.back();
            return false;
        });
    </script>
@stop
