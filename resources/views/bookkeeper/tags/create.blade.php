@extends('layouts.resources.form')

@php $formAction = route('bookkeeper.tags.store'); $formMethod = 'post' @endphp

@section('breadcrumbs')
    <a href="{{ route('bookkeeper.tags.index') }}" class="breadcrumbs__crumb">{{ uppercase(__('tags.title')) }}</a>
@endsection

@section('form')
    @inject('formBuilder', 'Bookkeeper\Html\FormBuilder')
    @php $formBuilder->configure($errors, 'tags.create'); @endphp

    {!! $formBuilder->build() !!}
@endsection

@section('form-buttons')
    {!! $formBuilder->buildSubmitButton('tags.create', 'tag') !!}
@endsection
