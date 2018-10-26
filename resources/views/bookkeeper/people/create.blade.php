@extends('layouts.resources.form')

@php $formAction = route('bookkeeper.people.store'); $formMethod = 'post' @endphp

@section('breadcrumbs')
    <a href="{{ route('bookkeeper.people.index') }}" class="breadcrumbs__crumb">{{ uppercase(__('people.title')) }}</a>
@endsection

@section('form')
    @inject('formBuilder', 'Bookkeeper\Html\FormBuilder')
    @php $formBuilder->configure($errors, 'people.create'); @endphp

    {!! $formBuilder->build() !!}
@endsection

@section('form-buttons')
    {!! $formBuilder->buildSubmitButton('people.create', 'user-plus') !!}
@endsection
