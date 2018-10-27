@extends('layouts.app')

@section('content')
    <div class="contents">
        <div class="contents__head level is-mobile">
            <div class="level-left">
                <div class="level-item">

                </div>
            </div>
            <div class="level-right">
                <div class="level-item">
                    @if (empty($__env->yieldContent('table-buttons')))
                        <a class="button is-primary is-overlay" href="{{ route('bookkeeper.' . $resourceName . '.create') }}"><i class="fa fa-plus"></i><span class="is-hidden-mobile">&nbsp;&nbsp;{{ __($resourceName . '.create') }}</span></a>
                    @else
                        @yield('table-buttons')
                    @endif
                </div>
            </div>
        </div>
        <div class="contents__body">
            <div class="contents__search has-text-centered">
                <form class="field has-addons search" method="GET" action="{{ route('bookkeeper.' . $resourceName . '.search') }}">
                    <p class="control">
                        <input class="input is-rounded" type="search" placeholder="{{ __($resourceName . '.search') }}" name="q" value="{{ request('q') }}">
                    </p>
                    <p class="control">
                        <button class="button is-overlay" type="submit">
                            <i class="fa fa-search"></i>
                        </button>
                    </p>
                </form>
            </div>
            <table class="table is-fullwidth is-hoverable">
                <thead>
                    <tr>
                        @yield('table-head')
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @if(isset($isSearch) && $isSearch && count(${$resourceName}) == 0)
                        {!! no_results_row('general.search_no_results') !!}
                    @else
                        @include($resourceName . '.list')
                    @endif
                </tbody>
            </table>
        </div>

        @unless(isset($isSearch) && $isSearch)
            @if(${$resourceName}->lastPage() > 1)
                <div class="contents__footer">
                    {!! ${$resourceName}->appends(request()->except('page'))->links('partials.pagination') !!}
                </div>
            @endif
        @endunless
    </div>
@endsection
