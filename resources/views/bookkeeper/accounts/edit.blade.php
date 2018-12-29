@extends('layouts.resources.form')

@php $formAction = route('bookkeeper.accounts.update', $account->getKey()); $formMethod = 'put' @endphp

@section('breadcrumbs')
    <a href="{{ route('bookkeeper.accounts.index') }}" class="breadcrumbs__crumb">{{ uppercase(__('accounts.title')) }}</a>
@endsection

@section('tabs')
    <li><a href="{{ route('bookkeeper.accounts.transactions', $account->getKey()) }}">{{ __('transactions.title') }}</a></li>
    <li><a href="{{ route('bookkeeper.accounts.show', $account->getKey()) }}">{{ __('overview.index') }}</a></li>
    <li class="is-active"><a href="{{ route('bookkeeper.accounts.edit', $account->getKey()) }}">{{ __('accounts.self') }}</a></li>
@endsection

@section('form')
    @inject('formBuilder', 'Bookkeeper\Html\FormBuilder')
    @php $formBuilder->configure($errors, 'accounts.edit', $account); @endphp

    {!! $formBuilder->build() !!}
@endsection

@section('form-buttons')
    {!! $formBuilder->buildSubmitButton('accounts.edit', 'save') !!}
@endsection
