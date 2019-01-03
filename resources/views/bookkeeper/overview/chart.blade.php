<div class="contents {{ isset($overrideTab) && $overrideTab ? '' : 'contents--overview' }}">
    <div class="contents__body contents__body--focus">
        <div class="chart-filter">
            <div class="dropdown is-right" id="chartFilter">
                <div class="dropdown-trigger">
                    <button class="button is-rounded chart-filter__button" aria-haspopup="true" id="chartFilterTrigger">
                        {!! Theme::img('img/calendar.svg') !!}
                    </button>
                </div>
                <div class="dropdown-menu" role="menu">
                    <div class="dropdown-content">
                        <div class="dropdown-item">
                            <h3 class="chart-filter__filter-title">{{ __('overview.filter_by_date_range') }}</h3>
                            <hr class="dropdown-divider">
                            <div class="field">
                                <label class="label" for="o_start">{{ __('overview.start_date') }}</label>
                                {!! html()->text('o_start', request('o_start', \Carbon\Carbon::now()->endOfMonth()->subYear()->addSecond()))->class('input datetime')->placeholder(__('overview.start_date')) !!}
                            </div>
                            <div class="field">
                                <label class="label" for="o_end">{{ __('overview.end_date') }}</label>
                                {!! html()->text('o_end', request('o_end', \Carbon\Carbon::now()->endOfMonth()))->class('input datetime')->placeholder(__('overview.end_date')) !!}
                            </div>
                            <div class="button is-primary is-fullwidth" id="filterInitiator" data-url="{{ url()->current() }}">{{ __('overview.filter') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="chart" id="chartTabs">
            <div class="chart__container">
                <div class="chart__warning">
                    <div class="chart__warning-inner">{!! __('overview.screen_size_warning') !!}</div>
                </div>
                <canvas height="{{ isset($overrideTab) && $overrideTab ? 96 : 112 }}" width="320" id="overviewGraph"></canvas>
            </div>
        </div>
        <div class="contents__interim">
            {!! transaction_buttons($transactionButtonsOptions, false) !!}
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

        var chartFilterTrigger = $('#chartFilterTrigger'),
            chartFilter = $('#chartFilter'),
            filterInitiator = $('#filterInitiator'),
            startPicker = $('#o_start'),
            endPicker = $('#o_end');

        chartFilterTrigger.click(function(e) {
            chartFilter.toggleClass('is-active');
        });

        filterInitiator.click(function() {
            window.location.href = $(this).data('url') + '?o_start=' + startPicker.val() + '&o_end=' + endPicker.val();
        })

    </script>
@endpush
