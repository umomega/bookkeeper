@extends('layouts.app')

@php
$currentSection = null;
$currentRoute = null;
@endphp

@section('content')
<div class="contents"
     id="updateIndicator"
     data-starturl="{{ route('bookkeeper.update.download') }}"
     data-completeurl="{{ route('bookkeeper.update.index') }}"
>
    <div class="contents__body contents__body--focus">
        <h3 class="contents__inner-heading contents__inner-heading--start has-text-primary"><i id="updaterIcon" class="fa fa-sync fa-spin"></i> {{ __('update.update_in_progress') }}</h3>

        <p id="updateMessage" class="contents__inner-text">{{ __('update.downloading_latest') }}</p>

        <progress id="updateProgress" class="progress is-large is-primary" value="3" max="100">3%</progress>
    </div>
</div>
@endsection

@section('scripts')
    {!! Theme::js('js/updater.js') !!}
@endsection
