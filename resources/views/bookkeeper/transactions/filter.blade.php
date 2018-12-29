<div class="filter">
    <p class="filter__label">{{ uppercase(trans('general.filter')) }}</p>
    <div class="field">
        <div class="control">
            <div class="select is-rounded is-fullwidth">
                @php
                $filterableURL = url()->current() . '?q=' . request('q') . '&f=';
                $filters = [];
                foreach(['all', 'income', 'expense', 'income-i', 'expense-i'] as $key) {
                    $filters[$filterableURL . $key] = __('transactions.f_' . $key);
                }
                @endphp
                {!! html()->select('transactionType', $filters, $filterableURL . request('f', 'all')); !!}
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script type="text/javascript">
    $('#transactionType').on('change', function () {
        window.location = $(this).find('option:selected').val();
    });
</script>
@endpush
