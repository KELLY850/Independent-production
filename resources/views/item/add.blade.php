@extends('adminlte::page')

@section('title', '商品登録')

@section('content_header')
    <h1>商品登録</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-10">
            <div class="card card-primary">
                <form method="POST" action="{{ route('items.confirm') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">名前</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="名前" value="{{ old('name') }}">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        </div>

                        <div class="form-group">
                            <label for="type">種別</label>
                            <select name="type" id="type" class="form-control">
                                @foreach($types as $key => $type)
                                <option value="{{ $key }}"{{ old('type') == $key ? 'selected' : '' }}>{{ $type }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="detail">価格</label>
                            <input type="number" class="form-control" id="price" name="price" placeholder="価格（半角数字）" value="{{ old('price') }}" min="0" max="10000000">
                        </div>
                        <div class="form-group">
                            <label for="status">ステータス</label>
                            <select name="status" id="status" class="form-control">
                                <option value="active">公開</option>
                                <option value="inactive"{{ old('status') == 'inactive' ? 'selected' : '' }}>非公開</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="detail">詳細</label>
                            <textarea class="form-control @error('detail') is-invalid @enderror" name="detail" id="detail" placeholder="詳細を入力してください">{{ old('detail') }}
                            </textarea>
                            @error('detail')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="image-upload">
                            <label for="detail">画像</label><br>
                            <input type="file" id="file" name="image" placeholder="画像ファイルを選択してください" value="{{ old('image') }}">
                            @error('image')
                                <div>{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">確認</button>
                    </div>
                </form>
            </div>
            <div class="go-back">
                    <button type="button" id="go-back" class="btn btn-primary">戻る</button>
            </div>

        </div>
    </div>
@stop

@section('css')
<link href="{{ asset('css/add.css') }}" rel="stylesheet">

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
