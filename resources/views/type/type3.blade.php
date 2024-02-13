@extends('adminlte::page')

@section('title', '車椅子')

@section('content_header')
    <h1>車椅子</h1>
@stop

@section('content')

    <div class="container">
        @foreach ($items as $item)
        <div class="box">
            @if($item->image)
            <a href="{{ route('types.detail', ['id' => $item->id]) }}">
                <!-- 画像をクリックしたら遷移するページを用意しておく。 -->
                <img src="{{ asset('storage/image/'.$item->image) }}" alt="" width="100%" class="img-thumbnail">
            </a>
            @else
            <a href="{{ route('types.detail', ['id' => $item->id]) }}">
                <img src="{{ asset('img/写真がない時.png')}}" width="100%" alt="" class="img-thumbnail">
            </a> 
            @endif
            <div class="text">
                <p>商品名：{{ $item->name }}</p>
                <p>料金:{{ $item->price }}円</p>
            </div>
        </div>
        @endforeach
    </div>


{{ $items->links() }}
@stop

@section('css')
    <link href="{{ asset('css/type.css') }}" rel="stylesheet">
@stop

@section('js')

@stop
