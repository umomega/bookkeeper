@extends('layouts.app')

@php $resourceName = 'tags' @endphp

@section('content')
<div class="level is-mobile">
    <div class="level-left">
        <div class="tags-search">
            @include('partials.search')
        </div>
    </div>
    <div class="level-right">
        <div class="level-item">
            <a class="tags-add button is-primary is-overlay" href="{{ route('bookkeeper.tags.create') }}"><i class="fa fa-tag"></i><span class="is-hidden-mobile">&nbsp;&nbsp;{{ __('tags.create') }}</span></a>
        </div>
    </div>
</div>
<div class="tags-list">
    <div class="tags-list__search">

    </div>

    @unless($isSearch)
    <div class="tags-list__sortable">
        @sortablelink('name', __('validation.attributes.name'))@sortablelink('created_at', __('validation.attributes.created_at'))
    </div>
    @endunless

    @if($isSearch && count($tags) == 0)
        <div class="contents__message has-text-centered">{{ __('general.search_no_results') }}</div>
    @else
        @if(count($tags) == 0 && !$isSearch)
            <div class="contents__message has-text-centered">{{ __('tags.no_tags') }}</div>
        @else
            <div class="field is-grouped is-grouped-multiline">
            @foreach($tags as $tag)
                <div class="control">
                    <div class="tags has-addons">
                        <a class="tag is-medium is-link" href="{{ route('bookkeeper.tags.transactions', $tag->getKey()) }}">{{ $tag->name }}</a>
                        <a class="tag is-delete is-medium delete-option" href="{{ route('bookkeeper.tags.destroy', $tag->getKey()) }}" data-message="{{ __('general.confirm_delete') }}"></a>
                    </div>
                </div>
            @endforeach
            </div>
        @endif
    @endif

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
