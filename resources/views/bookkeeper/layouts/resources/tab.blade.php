@extends('layouts.app')

@section('content')
    @if(!empty($__env->yieldContent('sidebar')))
        <div class="columns is-tablet">
            <div class="column is-two-thirds-tablet is-three-quarters-desktop">
    @endif

    <div class="tabs is-centered tabs--forms">
        <ul>
            @yield('tabs')
        </ul>
    </div>
    @if(isset($overrideTab) && $overrideTab)
        @yield('tab')
    @else
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
    @endif

    @if(!empty($__env->yieldContent('sidebar')))
            </div>
            <div class="column is-one-third-tablet is-one-quarter-desktop">
                <div class="contents-sidebar">
                    @yield('sidebar')
                </div>
            </div>
        </div>
    @endif

@endsection
