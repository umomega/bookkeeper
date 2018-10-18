@extends('layouts.app')

@section('content')
    <div class="contents">
        <div class="contents__head level is-mobile">
            <div class="level-left">
                <div class="level-item">
                    <form class="field has-addons search" method="GET" action="{{ route('bookkeeper.' . $resourceName . '.search') }}">
                        <p class="control">
                            <input class="input" type="search" placeholder="{{ __('general.search') }}" name="q">
                        </p>
                        <p class="control is-hidden-micro">
                            <button class="button is-primary" type="submit">
                                <i class="fa fa-search"></i>
                            </button>
                        </p>
                    </form>
                </div>
            </div>
            <div class="level-right">
                <div class="level-item">
                    @if (empty($__env->yieldContent('table-buttons')))
                        <a class="button is-primary is-action" href="{{ route('bookkeeper.' . $resourceName . '.create') }}"><i class="fa fa-plus"></i><span class="is-hidden-mobile">&nbsp;&nbsp;{{ __($resourceName . '.create') }}</span></a>
                    @else
                        @yield('table-buttons')
                    @endif
                </div>
            </div>
        </div>
        <div class="contents__body">
            <table class="table is-fullwidth is-hoverable">
                <thead>
                    <tr>
                        @yield('table-head')
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @include($resourceName . '.list')
                </tbody>
            </table>
        </div>

        @if(${$resourceName}->lastPage() > 1)
            <div class="contents__footer">
                {!! ${$resourceName}->appends(request()->except('page'))->links('partials.pagination') !!}
            </div>
        @endif
    </div>
@endsection
