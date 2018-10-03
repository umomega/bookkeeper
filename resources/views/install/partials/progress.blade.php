<div class="breadcrumb has-arrow-separator is-centered is-small" aria-label="breadcrumbs">
    <ul>
        @foreach(['welcome', 'database', 'user', 'settings', 'complete'] as $key => $step)
            <li{!! $currentStep > $key ? ' class="has-text-weight-bold"' : '' !!}>{{ __('install.step_' . $step) }}</li>
        @endforeach
    </ul>
</div>
