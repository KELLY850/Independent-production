@extends('adminlte::page')

@section('title', '商品詳細')

@section('content_header')
    <h1>商品詳細</h1>
@stop

@section('content')
    <div class="container">
        <div class="image-and-table">
            <div class="image">
            @if($item->image)
                <img src="{{ asset('storage/image/'.$item->image) }}" alt="" width="100%" height="auto" class="img-thumbnail">
            @else
                <img src="{{ asset('img/写真がない時.png')}}" width="100%"  alt="" class="img-thumbnail">
            @endif
            </div>
            <table class="table table-bordered border-info table-fixed-width">
                <tbody>
                    <tr>
                        <th scope="col" class="text-center ">ID</th>
                    </tr>
                    <tr>
                        <td class="text-center ">{{ $item->id }}</td>
                    </tr>
                    <tr>
                        <th scope="col" class="text-center">商品名</th>
                    </tr>
                    <tr>
                        <td class="text-center">{{ $item->name }}</td>
                    </tr>
                    <tr>
                        <th scope="col" class="text-center ">カテゴリー</th>
                    </tr>
                    <tr>
                        <td class="text-center">{{ $types[$item->type] }}</td>
                    </tr>
                    <tr>
                        <th scope="col" class="text-center ">価格</th>
                    </tr>
                    <tr>
                        <td class="text-center">{{ $item->price }}</td>
                    </tr>
                    <tr>
                        <th scope="col" class="text-center ">ステータス</th>
                    </tr>
                    <tr>
                        <td class="text-center">
                            @if($item->status === 'active')
                            公開
                            @elseif($item->status === 'inactive')
                            非公開
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th scope="col" class="text-center ">作成日</th>
                    </tr>
                    <tr>
                        <td class="text-center">{{ $item->created_at }}</td>
                    </tr>
                    <tr>
                        <th scope="col" class="text-center">更新日</th>
                    </tr>
                    <tr>
                        <td class="text-center">{{ $item->updated_at }}</td>
                    </tr>
                    <tr>
                        <th scope="col" class="text-center">詳細</th>
                    </tr>
                    <tr>
                    @if(!empty($item->detail))
                        <td class="text-left">{!! nl2br(e($item->detail)) !!}</td>
                    @else
                        <td class="text-center">詳細情報はありません</td>
                    @endif
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="btn-go-back">
        <button type="button" id="go-back" class="btn btn-primary">戻る</button>
    </div>


@stop

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <script>
        const back=document.getElementById("go-back");
        back.addEventListener("click",()=>{
            window.history.back();
            return false;
        });
    </script>

@stop
