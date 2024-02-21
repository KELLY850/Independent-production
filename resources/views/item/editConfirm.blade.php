@extends('adminlte::page')

@section('title', '商品編集')

@section('content_header')
    <h3>この内容でよろしいですか？</h3>
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

    <div class="container">
        <div class="image-and-table">
            <div class="image">

            <label for="detail">画像</label><br>
            @if(isset($image))
                <img src="{{ asset('storage/'. $image)}}" alt="" width="100%" class="img-thumbnail" value="1">
            @elseif(isset($oldImage))
                <img src="{{ asset('storage/'.$oldImage) }}" alt="" width="100%" class="img-thumbnail" value="2">
            @else
                <img src="{{ asset('img/写真がない時.png')}}" width="100%" alt="" class="img-thumbnail" value="3">
            @endif
            </div>
            <div class="card card-primary">
                <form method="POST" action="{{ route('items.update',[ 'id'=>$item->id ]) }}" enctype="multipart/form-data">
                @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">ID:{{ $item->id }}</label>
                        </div>
                        <!-- 仕切り線 -->
                        <hr class="hr1">

                        <div class="form-group">
                            <label for="name">名前</label>
                            <input type="text" class="form-control"  name="name" value="{{ $inputs['name'] }}" disabled>
                        </div>

                        <div class="form-group">
                            <label for="type">種別</label>
                            <select name="type" id="type" class="form-control" disabled>
                                <option>{{ $types[$inputs['type']] }}</option>
                            </select>

                        </div>
                        <div class="form-group">
                            <label for="detail">価格</label>
                            <input type="number" disabled class="form-control" name="price" value="{{ $inputs['price'] }}" min="0" max="10000000">
                        </div>
                        <div class="form-group">
                            <label for="status">ステータス</label>
                            <select name="status" id="status" class="form-control" disabled>
                                <option>
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
                            <textarea class="form-control" disabled name="detail" id="detail" style="height:50vh">{{$inputs['detail'] }}</textarea>
                        </div>
                        <div class="upload-btn">
                            <button type="submit" class="btn btn-primary">更新</button>
                        </div>
                    </div>
                </form>

                    <div class="button-container">
                        <div class="card-footer">
                            <a href="{{ route('items.index') }}" class="btn btn-primary">商品管理画面へ</a>
                        </div>
                        <form method="POST" action="{{ route('items.update',['id' => $item->id]) }}">
                        @csrf
                            <div class="card-footer">
                                <button type="submit" id="go-back" class="btn btn-primary">修正</button>
                            </div>
                        </form>
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
