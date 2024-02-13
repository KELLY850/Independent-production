@extends('adminlte::page')

@section('title', '商品編集')

@section('content_header')
    <h1>商品編集</h1>
@stop

@section('content')
    <div class="container">
        <div class="image-and-table">
            <div class="image">
                @if($item->image)
                    <img src="{{ asset('storage/image/'.$item->image) }}" alt="" width="100%" class="img-thumbnail">
                @else
                    <img src="{{ asset('img/写真がない時.png')}}" width="100%" alt="" class="img-thumbnail">
                @endif
            </div>
            <div class="card card-primary">
                <form method="POST" enctype="multipart/form-data">
                @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">ID:{{ $item->id }}</label>
                        </div>
                        <!-- 仕切り線 -->
                        <hr class="hr1">

                        <div class="form-group">
                            <label for="name">名前</label>
                            <input type="text" class="form-control"  name="name" value="{{ $item->name }}">
                        </div>

                        <div class="form-group">
                            <label for="type">種別</label>
                            <select name="type" id="type" class="form-control">
                                @foreach(config('category') as $key => $category)
                                <!-- ? : は、三項演算子（Ternary Operator）と呼ばれる構文で、
                                条件によって値を選択するための短縮記法
                                この構文は、条件が真の場合には「真の場合の値」を返し、
                                偽の場合には「偽の場合の値」を返します。$key が真の場合、'selected' を返し 
                                偽の場合、空文字列 '' を返す-->
                                <option value="{{ $key }}"{{ $item->type == $key ? 'selected' : '' }}>{{ $category }}</option>
                                @endforeach                   
                            </select>

                        </div>
                        <div class="form-group">
                            <label for="detail">価格</label>
                            <input type="number" class="form-control" name="price" value="{{ $item->price }}" min="0" max="10000000">
                        </div>
                        <div class="form-group">
                            <label for="status">ステータス</label>
                            <select name="status" id="status" class="form-control">
                                <option value="active" {{ $item->status === 'active' ? 'selected' : '' }}>公開</option>
                                <option value="inactive" {{ $item->status === 'inactive' ? 'selected' : '' }}>非公開</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="detail">詳細</label>
                            <textarea class="form-control" name="detail" id="detail">{{ $item->detail }}
                            </textarea>
                        </div>
                        <div class="form-group">
                            <label for="detail">画像</label><br>
                            <input type="file" id="file" name="image" placeholder="画像ファイルを選択してください">
                        </div>
                        <div class="upload-btn">
                            <button type="submit" class="btn btn-primary">更新</button>
                </form>
                        </div>
                        <form method="POST" action="{{ route('items.deleteImage', ['id' => $item->id]) }}" class="btn">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">画像を削除する</button>
                        </form>
                    </div>
                    <!-- 仕切り線 -->
                    <hr class="hr1">
                    <div class="button-container">
                        <div class="card-footer">
                            <a href="{{ route('items.index') }}" class="btn btn-primary">商品管理画面へ</a>
                        </div>
                        <div class="card-footer">
                            <button type="button" id="go-back" class="btn btn-primary">前のページに戻る</button>
                        </div>
                        <form method="POST">
                        @csrf
                        {{ method_field('DELETE') }}
                            <div class="card-footer">
                                <button type="submit" class="btn btn-danger">削除</button>
                            </div>
                        </form>
                    </div>
            </div>
        </div>
    </div>



@stop

@section('css')
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
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
