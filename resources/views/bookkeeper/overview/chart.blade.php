<div class="contents">
    <div class="contents__body contents__body--focus">
        <div class="chart" id="chartTabs">
            <div class="chart__container">
                <canvas height="{{ isset($overrideTab) && $overrideTab ? 96 : 112 }}" id="overviewGraph"></canvas>
            </div>
        </div>
        <div class="contents__interim">
            {!! transaction_buttons($transactionButtonsOptions) !!}
        </div>
    </div>
    <div class="contents__footer contents__footer--inverted contents__footer--focus">
        <div class="level">
            <div class="level-item has-text-centered">
                <div>
                    <h3 class="contents-sidebar__item-heading contents-sidebar__item-heading--inverted has-text-centered">{{ uppercase(__('overview.total_income')) }}</h3>
                    <p class="is-size-5">{{ $statistics['total_income'] }}</p>
                </div>
            </div>
            <div class="level-item has-text-centered">
                <div>
                    <h3 class="contents-sidebar__item-heading contents-sidebar__item-heading--inverted has-text-centered">{{ uppercase(__('overview.total_expense')) }}</h3>
                    <p class="is-size-5">{{ $statistics['total_expense'] }}</p>
                </div>
            </div>
            <div class="level-item has-text-centered">
                <div>
                    <h3 class="contents-sidebar__item-heading contents-sidebar__item-heading--inverted has-text-centered">{{ uppercase(__('overview.total_profit')) }}</h3>
                    <p class="is-size-5">{{ $statistics['total_profit'] }}</p>
                </div>
            </div>
            <div class="level-item has-text-centered">
                <div>
                    <h3 class="contents-sidebar__item-heading contents-sidebar__item-heading--inverted has-text-centered">{{ uppercase(__('overview.month_vat_difference', ['month' => $statistics['vatDifference']['vat_month']])) }}</h3>
                    <p class="is-size-5">{{ $statistics['vatDifference']['vat_difference'] }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    {!! Theme::js('js/vendor/Chart.bundle.min.js') !!}
    {!! Theme::js('js/charts.js') !!}

    <script type="text/javascript">
        var overviewOptions = {
            type: 'line',
            data: {
                labels: {!! json_encode($statistics['labels']) !!},
                datasets: [
                    @foreach($statistics['statistics'] as $type => $data)
                    $.extend({
                        label: '{{ uppercase(__('transactions.c_' . $type)) }}',
                        data: {!! json_encode($data) !!},
                        pointBackgroundColor: window.chartColors["{{ $type }}"].pointBackgroundColor,
                        borderColor: window.chartColors["{{ $type }}"].borderColor,
                        borderDash: window.chartColors["{{ $type }}"].borderDash,
                    }, window.chartDisplayDefaults),
                    @endforeach
                ]
            },
            options: {scales: {yAxes: [{gridLines: {color: 'transparent'}}]}}
        };

        window.onload = function () {
            var overviewCtx = document.getElementById("overviewGraph").getContext("2d");
            new Chart(overviewCtx, overviewOptions);
        }
    </script>
@endpush
