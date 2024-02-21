@extends('adminlte::page')


@section('title', '商品一覧')

@section('content_header')
    <h1>商品管理</h1>
@stop

@section('content')
    <form class="d-flex mt-3" action="{{ url('/items/') }}" method="get" role="search">
    @csrf
        <div class="col-auto">
            <select class="form-select" name="type">
                <option value="" selected>全て</option>
                @foreach($types as $key => $type)
                <option value="{{ $key }}"{{ $desiredType == $key ? 'selected' : '' }}>{{ $type }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-auto">
            <input class="form-control" type="search" name="keyword" value="{{ $keyword }}" placeholder="キーワード検索" aria-label="Search">
        </div>

        <div class="col-auto">
            <button class="btn btn-outline-success" type="submit">検索</button>
        </div>
    </form>
    @if(!empty($data) && $data->count() > 0)

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">商品一覧</h3>
                    <div class="card-tools">
                        <div class="input-group input-group-sm">
                            <div class="input-group-append">
                                <b>
                                <a href="{{ url('items/add') }}" class="btn-color">商品登録</a>
                                </b>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>名前</th>
                                <th>種別</th>
                                <th>ステータス</th>
                                <th>価格</th>
                                <th>更新日時</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->getPrefNameAttribute() }}</td>
                                    <td>{{ $item->status === "active" ? "公開" : "非公開" }}</td>
                                    <td>{{ $item->price }}円</td>
                                    <td>{{ $item->updated_at }}</td>
                                    <td><a href="{{ route('items.edit',['id' => $item->id]) }}" class="button">>>編集</a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @else
    <p class="text-center"><b>検索結果がありません。</b></p>
    @endif

    {{ $data->appends(request()->input())->links() }}

@stop

@section('css')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
<link href="{{ asset('css/home.css') }}" rel="stylesheet">

@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>

@stop

