@extends('layouts.resources.form')

@php $formAction = route('bookkeeper.transactions.update', $transaction->getKey()); $formMethod = 'put' @endphp

@section('breadcrumbs')
    <a href="{{ route('bookkeeper.transactions.index') }}" class="breadcrumbs__crumb">{{ uppercase(__('transactions.title')) }}</a>
@endsection

@section('form')
    @inject('formBuilder', 'Bookkeeper\Html\FormBuilder')
    @php
        $formBuilder
            ->configure($errors, 'transactions.edit', $transaction)
            ->setFieldConfiguration('account_id.choices', $accounts)
            ->setFieldConfiguration('type.choices', ['income' => __('transactions.income'), 'expense' => __('transactions.expense')]);
    @endphp

    {!! $formBuilder->build() !!}
@endsection

@section('form-buttons')
    {!! $formBuilder->buildSubmitButton('transactions.edit', 'save') !!}
@endsection

@section('sidebar')
    @include('transactions.tags', ['tags' => $transaction->tags, 'transaction' => $transaction])
@endsection

@push('scripts')
<script type="text/javascript">
    window.accountCurrencies = JSON.parse('{!! json_encode($accountCurrencies) !!}');
    var amount = new Amount($('#amountFieldAmount'), $('#account_id'), false);
    var tags = new Tags($('#tagSearch'), $('#subcontents'), false, null);
</script>
@endpush
