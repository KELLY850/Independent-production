@extends('adminlte::page')

@section('title', '商品編集')

@section('content_header')
    <h1>商品編集</h1>
@stop

@section('content')
<!-- この書き方のエラーも忘れないように -->
<!-- if (errors->any())
                <div class="alert alert-danger">
                    <ul>
                       foreach (errors->all() as error)
                          <li> error </li>
                       endforeach
                    </ul>
                </div>
endif -->
@if(session()->has('message'))
<div class="alert alert-success">
{{ session('message') }}
</div>
@endif
                        
    <div class="container">
        <div class="image-and-table">
            <div class="image">
                @if($item->image)
                    <img src="{{ asset('storage/'.$item->image) }}" alt="" width="100%" class="img-thumbnail">
                @else
                    <img src="{{ asset('img/写真がない時.png')}}" width="100%" alt="" class="img-thumbnail">
                @endif
                <form method="POST" action="{{ route('items.deleteImage', ['id' => $item->id]) }}" class="btn">
                @csrf
                    <button type="submit" class="btn btn-danger" name="delete_image">画像を削除する</button>
                </form>
            </div>
            <div class="card card-primary">
                <form method="POST" action="{{ route('items.edit.confirm',['id'=>$item->id]) }}" enctype="multipart/form-data">
                @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">ID:{{ $item->id }}</label>
                        </div>
                        <!-- 仕切り線 -->
                        <hr class="hr1">

                        <div class="form-group">
                            <label for="name">名前</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"  name="name" value="{{ old('name',isset($item) ? $item->name : '') }}">
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror

                        </div>

                        <div class="form-group">
                            <label for="type">種別</label>
                            <select name="type" id="type" class="form-control">
                                @foreach(config('category') as $key => $category)
                                <option value="{{ $key }}" {{ old('type', $item->type) == $key ? 'selected' : '' }}>
                                    {{ $category }} <!-- オプションの名前を表示 -->
                                </option>
                                @endforeach                   
                            </select>

                        </div>
                        <div class="form-group">
                            <label for="detail">価格</label>
                            <input type="number" class="form-control" name="price" value="{{ old('price', isset($item) ? $item->price : '') }}" min="0" max="10000000">
                        </div>
                        <div class="form-group">
                            <label for="status">ステータス</label>
                            <select name="status" id="status" class="form-control">
                                <option value="active" {{ (isset($item) && old('status', $item->status) === 'active') ? 'selected' : '' }}>公開</option>
                                <option value="inactive" {{ (isset($item) && old('status', $item->status) === 'inactive') ? 'selected' : '' }}>非公開</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="detail">詳細</label>
                            <textarea class="form-control @error('detail') is-invalid @enderror" name="detail" id="detail" style="height:50vh">{{ old('detail',isset($item) ? $item->detail:'') }}
                            </textarea>
                            @error('detail')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror

                        </div>
                        <div class="form-group">
                            <label for="detail">画像</label><br>
                            <input type="file" id="file" name="image" placeholder="画像ファイルを選択してください">
                            @error('image')
                                <div>{{ $message }}</div>
                            @enderror

                        </div>
                        <div class="upload-btn">
                            <button type="submit" class="btn btn-primary">編集確認</button>
                        </div>
                    </div>
                </form>

                    <div class="button-container">
                        <div class="card-footer">
                            <a href="{{ route('items.index') }}" class="btn btn-primary">商品管理画面へ</a>
                        </div>
                        <div class="card-footer">
                            <button type="button" id="go-back" class="btn btn-primary">前のページに戻る</button>
                        </div>
                        <form method="POST" action="{{ route('items.delete',['id' => $item->id]) }}">
                        @csrf
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
