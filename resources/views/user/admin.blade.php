@extends('adminlte::page')

@section('title', '社員管理')

@section('content_header')
    <h1>社員管理</h1>
@stop

@section('content')

    <form class="d-flex mt-3" action="{{ url('/users/admin') }}" method="get" role="search">
    @csrf
        <div class="col-auto">
            <select class="form-select" name="category">
                <option value="" selected>全て</option>
                <option value="admin">管理者</option>
                <option value="employee">一般社員</option>
            </select>
        </div>
        <div class="col-auto">
            <input class="form-control" type="search" name="keyword" value="{{ $keyword }}" placeholder="名前検索" aria-label="Search">
        </div>
        <div class="col-auto">
            <input class="form-control" type="search" name="katakana" value="{{ $katakana }}" placeholder="カタカナ検索" aria-label="Search">
        </div>
        <div class="col-auto">
            <button class="btn btn-outline-success" type="submit">検索</button>
        </div>

    </form>



    <div class="container">
        <table class="table table-bordered border-info table-fixed-width">
            <thead>
                <tr>
                    <th scope="col" class="text-center">ID</th>
                    <th scope="col" class="text-center">名前</th>
                    <th scope="col" class="text-center">メールアドレス</th>
                    <th scope="col" class="text-center">登録日</th>
                    <th scope="col" class="text-center"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr>
                    <td class="text-center">{{ $user->id }}</td>
                    <td class="text-center">{{ $user->name }}</td>
                    <td class="text-center">{{ $user->email }}</td>
                    <td class="text-center">{{ $user->created_at }}</td>
                    <td class="text-center">編集</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="page">
    <!-- ページネーションリンク -->
    {{ $users->links() }}
    </div>
@stop

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link href="{{ asset('css/user.css') }}" rel="stylesheet">
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>

@stop
