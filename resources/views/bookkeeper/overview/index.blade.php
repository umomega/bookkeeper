@extends('layouts.app')

@section('content')
    <div class="columns is-tablet">
        <div class="column is-two-thirds-tablet is-three-quarters-desktop">
            @if($statistics)
                @include('overview.chart', ['transactionButtonsOptions' => []])
            @else
                <div class="contents">
                    <div class="contents__body contents__body--focus has-text-centered">
                        <h2 class="contents__inner-heading contents__inner-heading--start">{{ __('overview.welcome_to_bookkeeper') }}</h2>
                        <p class="contents__inner-text">{!! __('overview.create_an_account_first', ['route' => route('bookkeeper.accounts.create')]) !!}</p>
                    </div>
                </div>
            @endif
        </div>
        <div class="column is-one-third-tablet is-one-quarter-desktop">
            <div class="contents-sidebar">
                <h3 class="contents-sidebar__heading">{{ __('accounts.title') }}</h3>
                <div class="contents contents--sidebar">
                    <div class="contents__body">
                        <div class="subcontents" id="subcontents">
                            @if(count($accounts) > 0)
                                @foreach($accounts as $account)
                                    <div class="subcontents__item">
                                        <h4 class="contents-sidebar__item-heading"><a href="{{ route('bookkeeper.accounts.transactions', $account->getKey()) }}">{{ uppercase($account->name) }}</a></h4>
                                        <a href="{{ route('bookkeeper.accounts.transactions', $account->getKey()) }}" class="is-size-5 contents-sidebar__item-text">{{ currency_string_for($account->balance, $account) }}</a>
                                    </div>
                                @endforeach
                            @else
                                <div class="subcontents__item subcontents__item--padded">
                                    {{ __('accounts.no_accounts') }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="contents__footer contents__footer--inverted">
                        <h4 class="contents-sidebar__item-heading contents-sidebar__item-heading--inverted">{{ uppercase(__('general.total')) }}</h4>
                        <p class="is-size-5 contents-sidebar__item-text has-text-left has-text-white">{{ $total }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
