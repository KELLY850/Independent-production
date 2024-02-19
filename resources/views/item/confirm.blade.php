@extends('adminlte::page')

@section('title', '入力確認画面')

@section('content_header')
    <h1>入力確認画面</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-10">
            <div class="card card-primary">
                <form method="POST" action="{{ route('items.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">名前</label>
                            <input type="input" class="form-control id="name" name="name" value="{{ $inputs['name'] }}" disabled>
                        </div>

                        <div class="form-group">
                            <label for="type">種別</label>
                            <select name="type" id="type" class="form-control" disabled>
                                <option >{{ $types[$inputs['type']] }}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="detail">価格</label>
                            <input class="form-control" id="price" name="price" value="{{ $inputs['price'] }}" disabled>
                        </div>
                        <div class="form-group">
                            <label for="status">ステータス</label>
                            <select disabled ="status" id="status" class="form-control">
                                <option >
                                    @if($inputs['status'] === 'active')
                                        公開
                                    @elseif($inputs['status'] === 'inactive')
                                        非公開
                                    @endif
                                </option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="detail">詳細</label>
                            <textarea disabled class="form-control" name="detail" id="detail">{{ $inputs['detail'] }}
                            </textarea>
                        </div>

                        <div class="image-upload">
                            <label for="detail">画像</label><br>
                            @if(isset($image))
                               <img src="{{ asset('storage/'. $image)}}" alt="">
                            @else
                              No image
                            @endif
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">登録</button>
                    </div>
                </form>
            </div>
            <form method="POST" action="{{ route('items.store') }}">
            @csrf
                <div class="go-back">
                        <button type="submit"  class="btn btn-primary" name="back">修正</button>
                </div>
            </form>
        </div>
    </div>
@stop

@section('css')
<link href="{{ asset('css/add.css') }}" rel="stylesheet">

@stop

@section('js')
@stop
