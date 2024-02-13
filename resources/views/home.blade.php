@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>ようこそ</h1>
@stop

@section('content')
    <p>介護用品をお探しですか？</p>
    <ul>
        <li>
            <a href="{{ url('types/1') }}">
                <img src="{{ asset('img/歩行器.jpeg')}}" width="300" height="200" alt="">
            </a>
        </li>
        <li>
            <a href="{{ url('types/2') }}">
                <img src="{{ asset('img/杖.jpeg')}}" width="300" height="200" alt="">
            </a>
        </li>
        <li>
            <a href="{{ url('types/3') }}">
                <img src="{{ asset('img/車椅子.jpeg')}}" width="300" height="200" alt="">
            </a>
        </li>
    </ul>
    <ul>
        <li>
            <a href="{{ url('types/4') }}">
                <img src="{{ asset('img/手すり.jpeg')}}" width="300" height="200" alt="">
            </a>
        </li>
        <li>
            <a href="{{ url('types/5') }}">
                <img src="{{ asset('img/電動ベッド.jpeg')}}" width="300" height="200" alt="">
            </a>
        </li>
    </ul>



@stop

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
    <link href="{{ asset('css/home.css') }}" rel="stylesheet">

@stop

@section('js')
  
@stop

