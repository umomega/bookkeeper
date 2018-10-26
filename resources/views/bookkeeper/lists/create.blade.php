@extends('layouts.resources.form')

@php $formAction = route('bookkeeper.lists.store'); $formMethod = 'post' @endphp

@section('breadcrumbs')
    <a href="{{ route('bookkeeper.lists.index') }}" class="breadcrumbs__crumb">{{ uppercase(__('lists.title')) }}</a>
@endsection

@section('form')
    @inject('formBuilder', 'Bookkeeper\Html\FormBuilder')
    @php $formBuilder->configure($errors, 'lists.create'); @endphp

    {!! $formBuilder->build() !!}
@endsection

@section('form-buttons')
    {!! $formBuilder->buildSubmitButton('lists.create', 'plus') !!}
@endsection
