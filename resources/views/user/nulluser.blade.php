@extends('adminlte::page')

@section('title', 'ユーザー管理')

@section('content_header')
    <h1>アカウント管理</h1>
@stop

@section('content')

    <div class="container">
        <table class="table table-bordered border-info table-fixed-width">
            <tbody>
                    <tr>
                        <th scope="col" class="text-center ">ID</th>
                        <th scope="col" class="text-center ">名前</th>
                        <th scope="col" class="text-center ">メールアドレス</th>
                        <th scope="col" class="text-center ">登録日</th>
                        <th scope="col" class="text-center "></th>
                    </tr>
        @foreach ($users as $user)
                    <tr>
                        <td class="text-center ">{{ $user->id }}</td>
                        <td class="text-center ">{{ $user->name }}</td>
                        <td class="text-center ">{{ $user->email }}</td>
                        <td class="text-center ">{{ $user->created_at }}</td>
                        <td class="text-center ">編集</td>
                    </tr>
        @endforeach
            </tbody>
        </table>
    </div>


{{ $users->links() }}
@stop

@section('css')
    <link href="{{ asset('css/user.css') }}" rel="stylesheet">
@stop

@section('js')

@stop
