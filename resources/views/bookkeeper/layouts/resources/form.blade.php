@extends('layouts.app')

@section('content')
    <div class="tabs is-centered tabs--forms">
        <ul>
            @yield('tabs')
        </ul>
    </div>
    <div class="contents contents--form">
        <div class="contents__body">
            <form action="{{ $formAction }}" method="post" class="form">
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
@endsection
