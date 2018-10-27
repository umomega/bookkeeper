@extends('layouts.resources.tab')

@section('breadcrumbs')
    <a href="{{ route('bookkeeper.people.index') }}" class="breadcrumbs__crumb">{{ uppercase(__('people.title')) }}</a>
@endsection

@section('tabs')
    <li><a href="{{ route('bookkeeper.people.edit', $person->getKey()) }}">{{ __('people.self') }}</a></li>
    <li class="is-active"><a href="{{ route('bookkeeper.people.lists', $person->getKey()) }}">{{ __('lists.title') }}</a></li>
@endsection

@section('tab')
    <table class="table is-fullwidth is-hoverable">
        <thead>
            <tr>
                <th>{{ __('validation.attributes.name') }}</th>
                <th class="is-hidden-mobile">{{ __('validation.attributes.created_at') }}</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @include('lists.sublist', ['lists' => $person->lists])
        </tbody>
    </table>

    @if(count($availableLists) > 0)
    <hr>

    <h3 class="contents__inner-heading">{{ __('lists.associate') }}</h3>
    <form action="{{ route('bookkeeper.people.lists.associate', $person->getKey()) }}" class="subform" method="post">
        @csrf
        @method('put')

        <div class="field has-addons is-pulled-left">
            <div class="control">
                <div class="select is-rounded">
                    {!! html()->select('list', $availableLists) !!}
                </div>
            </div>
            <div class="control">
                <button type="submit" class="button is-primary is-rounded">
                    <i class="fa fa-plus"></i>&nbsp;&nbsp;{{ __('lists.associate') }}
                </button>
            </div>
        </div>

    </form>
    @endif

@endsection
