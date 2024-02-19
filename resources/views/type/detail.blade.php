@extends('adminlte::page')

@section('title', '商品詳細')

@section('content_header')
<h1>{{ $item->name }}</h1>
@stop

@section('content')
<div class="d-flex justify-content-center">
    <div class="image">
        @if($item->image)
        <img src="{{ asset('storage//'.$item->image) }}" alt="" width="50%" height="auto" class="img-thumbnail">
        @else
        <img src="{{ asset('img/写真がない時.png')}}" width="50%%" alt="" class="img-thumbnail">
        @endif
    </div>
</div>
<div class="text-center">
    <div class="price">
        <b class="hutoji">価格</b>
        <p>¥{{ $item->price }}</p>
    </div>
</div>
<div class="text-left">
    <div class="detail">
        <b class="hutoji">この商品について</b>
        <hr class="hr1">
        @if(!empty($item->detail))
        <p class="detail">{!! nl2br(e($item->detail)) !!}</p>
        @else
        <p class="detail">詳細情報はありません</p>
        @endif


    </div>
</div>
<hr class="hr1">
<div class="btn-go-back">
    <button type="button" id="go-back" class="btn btn-primary">戻る</button>
</div>



@stop

@section('css')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
<link href="{{ asset('css/detail.css') }}" rel="stylesheet">

@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
<script>
    const back = document.getElementById("go-back");
    back.addEventListener("click", () => {
        window.history.back();
        return false;
    });
</script>
@stop