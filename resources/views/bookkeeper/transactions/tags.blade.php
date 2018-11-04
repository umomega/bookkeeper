<h3 class="contents-sidebar__heading">{{ __('tags.title') }}</h3>
<div class="contents contents--sidebar">
    <div class="contents__body">
        <div class="tags-list-sub field is-grouped is-grouped-multiline" id="subcontents">
            <div class="subcontents__item subcontents__item--padded" {!! count($tags) > 0 ? 'style="display: none"' : '' !!}>
                {{ __('tags.no_tags') }}
            </div>
            @if(count($tags) > 0)
                @foreach($tags as $tag)
                    <div class="tag-sub control" data-tagid="{{ $tag->getKey() }}"><div class="tags has-addons">
                        <a class="tag is-medium is-link" href="{{ route('bookkeeper.tags.show', $tag->getKey()) }}">{{ $tag->name }}</a>
                        <a class="tag is-delete is-medium tag-detach" href="{{ route('bookkeeper.tags.transactions.dissociate', [$tag->getKey(), $transaction->getKey()]) }}"></a>
                    </div></div>
                @endforeach
            @endif
        </div>
    </div>
    <div class="contents__footer contents__footer--inverted">
        <h4 class="contents-sidebar__item-heading contents-sidebar__item-heading--inverted">{{ uppercase(__('tags.type_to_add')) }}</h4>
        <div id="tagSearch" class="searcher"
            data-searchurl="{{ route('bookkeeper.tags.search.json') }}">
            <input type="hidden" name="_exclude" value="{{ json_encode($tags->pluck('id')) }}">
            <input type="hidden" name="_additional" value="{{ json_encode(is_null($transaction) ? [] : ['transaction_id' => $transaction->getKey()]) }}">
            <input type="text" name="_searcher" autocomplete="off" placeholder="{{ __('general.search') }}" class="searcher__input">
            <p class="searcher__hint">{{ __('tags.choose_from_results_to_add') }}</p>

            <ul class="searcher__results">

            </ul>
        </div>
    </div>
</div>
