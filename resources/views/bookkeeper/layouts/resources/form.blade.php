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
    <div class="contents">
        <div class="contents__head">
            @yield('contents-head')
        </div>
        <div class="contents__body">
            <form action="{{ $formAction }}" method="post" class="form" enctype="multipart/form-data">
                @csrf
                @if($formMethod == 'put')
                    @method('put')
                @endif

                @yield('form')

                <div class="form__buttons">
                    @yield('form-buttons')
                </div>
            </form>
        </div>
    </div>

    @if(!empty($__env->yieldContent('sidebar')))
            </div>
            <div class="column is-one-third-tablet is-quarter-desktop">
                <div class="contents-sidebar">
                    @yield('sidebar')
                </div>
            </div>
        </div>
    @endif

@endsection
