<div>
    <h2 class="contents__inner-heading contents__inner-heading--start has-text-danger"><i class="fa fa-times-circle"></i> {{ __('update.bookkeeper_is_not_up_to_date') }}</h2>
    <p class="contents__inner-text">{!! __('update.not_up_to_date_description', ['latest' => $latest->tag_name, 'version' => bookkeeper_version()]) !!}</p>
</div>

<hr>

<div>
    <h3 class="contents__inner-heading contents__inner-heading--start has-text-primary"><i class="fa fa-sync"></i> {{ __('update.auto_update') }}</h3>
    <p class="contents__inner-text contents__inner-text--separated">{{ __('update.auto_update_description') }}</p>

    <a class="button is-primary is-overlay" href="{{ route('bookkeeper.update.start') }}"><i class="fa fa-sync"></i>&nbsp;&nbsp;{{ __('update.start') }}</a>
</div>
