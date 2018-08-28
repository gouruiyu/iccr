@extends('layouts.default')
@section('title','ICCr - Welcome')

@section('content')
@if (Auth::check())
<div class="row">
    <div class="col-md-8">
        <section class="status_form">
            @include('shared._status_form')
        </section>
    </div>
    <aside class="col-md-4">
        <section class="user_info">
            @include('shared._user_info', ['user' => Auth::user()])
        </section>
    </aside>
</div>
@else
<div class="jumbotron">
    <h1>欢迎来到拉莱耶。</h1>
    <p class="lead">
    	今日训诫：
    </p>
    <p>
    	游戏独立了，经济独立了吗？
    </p>
    <p>
      <a class="btn btn-lg btn-success" href="{{ route('signup') }}" role="button">注册账号</a>
    </p>
</div>
@endif
@stop