@extends('layouts.app')

@section('content')
    <div class="tabs is-centered tabs--forms">
        <ul>
            @yield('tabs')
        </ul>
    </div>
    <div class="contents contents--form">
        <div class="contents__body">
            @yield('tab')
        </div>
    </div>
@endsection
