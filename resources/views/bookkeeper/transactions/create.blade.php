@extends('layouts.resources.form')

@php $formAction = route('bookkeeper.transactions.store'); $formMethod = 'post' @endphp

@section('breadcrumbs')
    <a href="{{ route('bookkeeper.transactions.index') }}" class="breadcrumbs__crumb">{{ uppercase(__('transactions.title')) }}</a>
@endsection

@section('form')
    @inject('formBuilder', 'Bookkeeper\Html\FormBuilder')
    @php
        $model = new \Bookkeeper\Finance\Transaction;
        $model->amount = 0;

        if(request()->account) {
            $model->account_id = request()->account;
        } elseif(request()->job && $job = \Bookkeeper\Finance\Job::find(request()->job)) {
            $model->job_id = $job->getKey();
            $model->job = $job;
        }

        $formBuilder
            ->configure($errors, 'transactions.create', $model)
            ->setFieldConfiguration('account_id.choices', $accounts)
            ->setFieldConfiguration('created_at.default', date('Y-m-d G:i:s'))
            ->setFieldConfiguration('type.choices', ['income' => __('transactions.income'), 'expense' => __('transactions.expense')])
            ->setFieldConfiguration('type.default', request()->get('type'));
    @endphp

    {!! $formBuilder->build() !!}
@endsection

@section('form-buttons')
    {!! $formBuilder->buildSubmitButton('transactions.create', 'save') !!}
@endsection

@section('sidebar')
    @php
    $tags = request()->tag ?
        \Bookkeeper\Finance\Tag::whereIn('id', [request()->tag])->get() :
        collect();
    @endphp

    @include('transactions.tags', ['tags' => $tags, 'transaction' => null])
@endsection

@push('scripts')
<script type="text/javascript">
    window.accountCurrencies = JSON.parse('{!! json_encode($accountCurrencies) !!}');
    var amount = new Amount($('#amountFieldAmount'), $('#account_id'), false);
    var tags = new Tags($('#tagSearch'), $('#subcontents'), true, $('#tags'));
</script>
@endpush
