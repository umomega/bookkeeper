@extends('layouts.resources.form')

@php $formAction = route('bookkeeper.tags.update', $tag->getKey()); $formMethod = 'put' @endphp

@section('breadcrumbs')
    <a href="{{ route('bookkeeper.tags.index') }}" class="breadcrumbs__crumb">{{ uppercase(__('tags.title')) }}</a>
@endsection

@section('tabs')
    <li><a href="{{ route('bookkeeper.tags.show', $tag->getKey()) }}">{{ __('overview.index') }}</a></li>
    <li><a href="{{ route('bookkeeper.tags.transactions', $tag->getKey()) }}">{{ __('transactions.title') }}</a></li>
    <li class="is-active"><a href="{{ route('bookkeeper.tags.edit', $tag->getKey()) }}">{{ __('tags.self') }}</a></li>
@endsection

@section('form')
    @inject('formBuilder', 'Bookkeeper\Html\FormBuilder')
    @php $formBuilder->configure($errors, 'tags.create', $tag); @endphp

    {!! $formBuilder->build() !!}
@endsection

@section('form-buttons')
    {!! $formBuilder->buildSubmitButton('tags.edit', 'save') !!}
@endsection
