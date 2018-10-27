@extends('layouts.app')

@section('content')
    <div class="tabs is-centered tabs--forms">
        <ul>
            @yield('tabs')
        </ul>
    </div>
    <div class="contents">
        <div class="contents__head">
            @yield('contents-head')
        </div>
        <div class="contents__body">
            @yield('tab')
        </div>
        @yield('contents-footer')
    </div>
@endsection
