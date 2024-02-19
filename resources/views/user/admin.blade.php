@extends('adminlte::page')

@section('title', 'アカウント管理')

@section('content_header')
    <h1>アカウント管理</h1>
@stop

@section('content')

    <form class="d-flex mt-3" method="get" role="search">
    @csrf
        <div class="col-auto">
            <select class="form-select" name="category">
                <option value="" {{ $category === '' ? 'selected' : '' }}>全て</option>
                <option value="admin" {{  $category === 'admin' ? 'selected' : '' }}>管理者</option>
                <option value="employee" {{ $category === 'employee' ? 'selected' : '' }}>社員</option>
                <option value="user" {{ $category === 'user' ? 'selected' : '' }}>ユーザー</option>
            </select>
        </div>
        <div class="col-auto">
            <input class="form-control" type="search" id="keyword" name="keyword" value="{{ $keyword }}" placeholder="名前にスペースをあけてください" aria-label="Search" style="width:18vw;">
        </div>
        <div class="col-auto">
            <button class="btn btn-outline-success" type="submit">検索</button>
        </div>

    </form>


@if(!empty($data) && $data->count() > 0)
    <div class="container">
        <table class="table table-bordered border-info table-fixed-width">
            <thead>
                <tr>
                    <th scope="col" class="text-center">ID</th>
                    <th scope="col" class="text-center">名前</th>
                    <th scope="col" class="text-center">メールアドレス</th>
                    <th scope="col" class="text-center">権限</th>
                    <th scope="col" class="text-center">登録日</th>
                    <th scope="col" class="text-center"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $user)
                <tr>
                    <td class="text-center">{{ $user->id }}</td>
                    <td class="text-center">{{ $user->name }}</td>
                    <td class="text-center">{{ $user->email }}</td>
                    <td class="text-center">
                        @if($user->role === 'admin')
                            管理者
                        @elseif($user->role === 'employee')
                            社員
                        @else
                            ユーザー
                        @endif
                    </td>
                    <td class="text-center">{{ $user->created_at }}</td>
                    <td class="text-center">
                        <a href="{{ url('users/admin/'.$user->id) }}">編集</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <p class="text-center"><b>検索結果がありません。</b></p>
    @endif
    <div class="page">
    <!-- ページネーションリンク -->
    {{ $data->appends(request()->input())->links() }}
    </div>
@stop

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link href="{{ asset('css/user.css') }}" rel="stylesheet">
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>


@stop
