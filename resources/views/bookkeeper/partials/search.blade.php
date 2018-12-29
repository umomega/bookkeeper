<div class="contents__search">
    <form class="search" method="GET" action="{{ (isset($route) ? $route : route('bookkeeper.' . $resourceName . '.index')) }}">
        <p class="search__label">{{ uppercase(trans('general.search')) }}</p>
        <div class="field has-addons">
            <p class="control">
                <input class="input is-rounded" type="search" placeholder="{{ __($resourceName . '.search') }}" name="q" value="{{ request('q') }}">
            </p>
            <p class="control">
                <button class="button is-overlay" type="submit">
                    <i class="fa fa-search"></i>
                </button>
            </p>
        </div>
        <input type="hidden" name="f" value="{{ request('f', 'all') }}">
    </form>

    @yield('filters')
</div>
