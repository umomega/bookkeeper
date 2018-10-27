<div class="contents__search has-text-centered">
    <form class="field has-addons search" method="GET" action="{{ (isset($route) ? $route : route('bookkeeper.' . $resourceName . '.index')) }}">
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
