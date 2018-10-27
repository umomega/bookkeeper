@extends('layouts.app')

@section('content')
    <div class="contents">
        <div class="contents__head level is-mobile">
            <div class="level-left"></div>
            <div class="level-right">
                <div class="level-item">
                    @if(empty($__env->yieldContent('table-buttons')))
                        <a class="button is-primary is-overlay" href="{{ route('bookkeeper.' . $resourceName . '.create') }}"><i class="fa fa-plus"></i><span class="is-hidden-mobile">&nbsp;&nbsp;{{ __($resourceName . '.create') }}</span></a>
                    @else
                        @yield('table-buttons')
                    @endif
                </div>
            </div>
        </div>
        <div class="contents__body">

            @include('partials.search')

            <table class="table is-fullwidth is-hoverable">
                <thead>
                    <tr>
                        @yield('table-head')
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @if($isSearch && count(${$resourceName}) == 0)
                        {!! no_results_row('general.search_no_results') !!}
                    @else
                        @include($resourceName . '.list')
                    @endif
                </tbody>
            </table>
        </div>

        @if($isSearch)
            <div class="contents__footer"><a href="{{ route('bookkeeper.' . $resourceName . '.index') }}"><i class="fa fa-arrow-left"></i>&nbsp;&nbsp;{{ __($resourceName . '.all') }}</a></div>
        @else
            @if(${$resourceName}->lastPage() > 1)
                <div class="contents__footer">
                    {!! ${$resourceName}->appends(request()->except('page'))->links('partials.pagination') !!}
                </div>
            @endif
        @endif
    </div>
@endsection
