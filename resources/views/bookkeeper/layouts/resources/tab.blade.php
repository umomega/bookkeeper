@extends('layouts.app')

@section('content')
    @if(!empty($__env->yieldContent('sidebar')))
        <div class="columns">
            <div class="column is-three-quarters">
    @endif

    <div class="tabs is-centered tabs--forms">
        <ul>
            @yield('tabs')
        </ul>
    </div>
    <div class="contents">
        <div class="contents__head level is-mobile">
            <div class="level-left"></div>
            <div class="level-right">
                <div class="level-item">
                    @yield('table-buttons')
                </div>
            </div>
        </div>
        <div class="contents__body">
            @yield('tab')
        </div>
        @yield('contents-footer')
    </div>

    @if(!empty($__env->yieldContent('sidebar')))
            </div>
            <div class="column is-quarter">
                @yield('sidebar')
            </div>
        </div>
    @endif

@endsection
