@extends('layouts.resources.form')

@php $formAction = route('bookkeeper.lists.update', $list->getKey()); $formMethod = 'put' @endphp

@section('breadcrumbs')
    <a href="{{ route('bookkeeper.lists.index') }}" class="breadcrumbs__crumb">{{ uppercase(__('lists.title')) }}</a>
@endsection

@section('tabs')
    <li><a href="{{ route('bookkeeper.lists.show', $list->getKey()) }}">{{ __('people.title') }}</a></li>
    <li class="is-active"><a href="{{ route('bookkeeper.lists.edit', $list->getKey()) }}">{{ __('lists.self') }}</a></li>
@endsection

@section('form')
    @inject('formBuilder', 'Bookkeeper\Html\FormBuilder')
    @php $formBuilder->configure($errors, 'lists.create', $list); @endphp

    {!! $formBuilder->build() !!}
@endsection

@section('form-buttons')
    {!! $formBuilder->buildSubmitButton('lists.edit', 'save') !!}
@endsection
