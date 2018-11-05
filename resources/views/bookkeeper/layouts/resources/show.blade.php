@extends('layouts.resources.tab')

@section('tab')
    @include('partials.search', ['route' => $showRoute, 'resourceName' => $resourceName])

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
                @include($resourceName . '.list', ['resourceName' => $resourceName])
            @endif
        </tbody>
    </table>
@endsection

@section('contents-footer')
    @if($isSearch)
        <div class="contents__footer"><a href="{{ $showRoute }}"><i class="fa fa-arrow-left"></i>&nbsp;&nbsp;{{ __($resourceName . '.all') }}</a></div>
    @else
        @if(${$resourceName}->lastPage() > 1)
            <div class="contents__footer">
                {!! ${$resourceName}->appends(request()->except('page'))->links('partials.pagination') !!}
            </div>
        @endif
    @endif
@endsection
