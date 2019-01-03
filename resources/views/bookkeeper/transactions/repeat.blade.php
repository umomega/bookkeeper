@extends('layouts.resources.form')

@php $formAction = route('bookkeeper.transactions.store'); $formMethod = 'post' @endphp

@section('breadcrumbs')
    <a href="{{ route('bookkeeper.transactions.index') }}" class="breadcrumbs__crumb">{{ uppercase(__('transactions.title')) }}</a>
@endsection

@section('form')
    @inject('formBuilder', 'Bookkeeper\Html\FormBuilder')
    @php
        $transaction->created_at = date('Y-m-d G:i:s');
        $transaction->received_at = date('Y-m-d G:i:s');
        $transaction->invoice = '';
        $formBuilder
            ->configure($errors, 'transactions.create', $transaction)
            ->setFieldConfiguration('account_id.choices', $accounts)
            ->setFieldConfiguration('type.choices', ['income' => __('transactions.income'), 'expense' => __('transactions.expense')]);
    @endphp

    {!! $formBuilder->build() !!}
@endsection

@section('form-buttons')
    {!! $formBuilder->buildSubmitButton('transactions.create', 'save') !!}
@endsection

@section('sidebar')
    @include('transactions.tags', ['tags' => $transaction->tags, 'transaction' => null])
@endsection

@push('scripts')
<script type="text/javascript">
    window.accountCurrencies = JSON.parse('{!! json_encode($accountCurrencies) !!}');
    var amount = new Amount($('#amountFieldAmount'), $('#account_id'), false);
    var tags = new Tags($('#tagSearch'), $('#subcontents'), true, $('#tags'));
</script>
@endpush
