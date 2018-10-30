@extends('layouts.resources.form')

@php $formAction = route('bookkeeper.accounts.store'); $formMethod = 'post' @endphp

@section('breadcrumbs')
    <a href="{{ route('bookkeeper.accounts.index') }}" class="breadcrumbs__crumb">{{ uppercase(__('accounts.title')) }}</a>
@endsection

@section('form')
    @inject('formBuilder', 'Bookkeeper\Html\FormBuilder')
    @php $formBuilder->configure($errors, 'accounts.create'); @endphp

    {!! $formBuilder->build() !!}
@endsection

@section('form-buttons')
    {!! $formBuilder->buildSubmitButton('accounts.create', 'plus') !!}
@endsection

@push('scripts')
<script type="text/javascript">
    var amount = new Amount($('#amountFieldBalance'), $('#currency'), true);
</script>
@endpush
