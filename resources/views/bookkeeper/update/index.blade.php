@extends('layouts.app')

@php
$currentSection = null;
$currentRoute = null;
@endphp

@section('content')
    <div class="contents">
        <div class="contents__body contents__body--focus">
        @if($updater->isBookkeeperCurrent())
            <div>
                <h2 class="contents__inner-heading contents__inner-heading--start has-text-success"><i class="fa fa-check-circle"></i> {{ __('update.bookkeeper_is_up_to_date') }}</h2>
                <p class="contents__inner-text">{!! __('update.up_to_date_description', ['version' => bookkeeper_version()]) !!}</p>
            </div>
        @else
            @include('update.description')
        @endif
        </div>
    </div>
@endsection
