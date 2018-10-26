@extends('layouts.resources.form')

@php $formAction = route('bookkeeper.people.update', $person->getKey()); $formMethod = 'put' @endphp

@section('breadcrumbs')
    <a href="{{ route('bookkeeper.people.index') }}" class="breadcrumbs__crumb">{{ uppercase(__('people.title')) }}</a>
@endsection

@section('tabs')
    <li class="is-active"><a href="{{ route('bookkeeper.people.edit', $person->getKey()) }}">{{ __('people.self') }}</a></li>
    <li><a href="{{ route('bookkeeper.people.lists', $person->getKey()) }}">{{ __('lists.title') }}</a></li>
@endsection

@section('form')
    @inject('formBuilder', 'Bookkeeper\Html\FormBuilder')
    @php $formBuilder->configure($errors, 'people.create', $person); @endphp

    {!! $formBuilder->build() !!}
@endsection

@section('form-buttons')
    {!! $formBuilder->buildSubmitButton('people.edit', 'save') !!}
@endsection
