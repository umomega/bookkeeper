@extends('layouts.resources.form')

@php $formAction = route('bookkeeper.users.store'); $formMethod = 'post' @endphp

@section('breadcrumbs')
    <a href="{{ route('bookkeeper.users.index') }}" class="breadcrumbs__crumb">{{ uppercase(__('users.title')) }}</a>
@endsection

@section('form')
    @inject('formBuilder', 'Bookkeeper\Html\FormBuilder')
    @php $formBuilder->configure($errors, 'users.create'); @endphp

    {!! $formBuilder->build() !!}
@endsection

@section('form-buttons')
    {!! $formBuilder->buildSubmitButton('users.create', 'user-plus') !!}
@endsection
