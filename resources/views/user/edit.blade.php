@extends('adminlte::page')

@section('title', 'アカウント編集')

@section('content_header')
    <h1>アカウント編集</h1>
@stop

@section('content')
    <div class="row">
            <div class="col-md-10">
                <div class="card card-primary">
                    <form method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label for="id">ID:{{ $user->id }}</label><br>                        
                                <label for="name">名前</label><br>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"  value="{{ old('name',isset($user) ?  $user->name : '') }}">
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="name_katakana">フリガナ</label><br>
                                <input type="text" class="form-control @error('name_katakana') is-invalid @enderror" id="name_katakana" name="name_katakana"  value="{{ old('name_katakana',isset($user) ?  $user->name_katakana : '') }}">
                                @error('name_katakana')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="email">メールアドレス</label><br>
                                <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" name="email"  value="{{ old('email',isset($user) ?  $user->email : '') }}">
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="role">権限</label><br>
                                <select name="role" id="role" class="form-control">
                                    <option value="" {{ (isset($user) && old('role', $user->role) === '') ? 'selected' : '' }}>ユーザー</option>
                                    <option value="employee" {{ (isset($user) && old('role', $user->role) === 'employee') ? 'selected' : '' }}>社員</option>
                                    <option value="admin" {{ (isset($user) && old('role', $user->role) === 'admin') ? 'selected' : '' }}>管理者</option>
                                </select>
                                
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            @if(session()->has('message'))
                                <div class="alert alert-success">
                                    {{ session('message') }}
                                </div>
                            @endif
                            <div>
                                <button type="submit" class="btn btn-primary">編集</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
    </div>
    <div class="btn-content">
        <div class="go-back">
            <button type="button" id="go-back" class="btn btn-primary">戻る</button>
        </div>
        <form method="POST" action="{{ route('users.delete',['id' => $user->id]) }}">
        @csrf
            <div class="card-footer">
                <button type="submit" class="btn btn-danger">削除</button>
            </div>
        </form>
    </div>



@stop

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link href="{{ asset('css/user.edit.css') }}" rel="stylesheet">
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
