<div class="dropdown is-hoverable">
    <div class="dropdown-trigger">
        <button class="button content-option is-rounded" aria-haspopup="true" aria-controls="dropdown-menu4">
            <span>{{ __('general.export') }}</span>
            <span class="icon is-small">
                <i class="fas fa-angle-down" aria-hidden="true"></i>
            </span>
        </button>
    </div>
    <div class="dropdown-menu" id="dropdown-menu4" role="menu">
        <div class="dropdown-content content-option-dropdown">
            <a href="{{ $baseURL . '&format=xlsx' }}" target="_blank" class="dropdown-item">XLSX</a>
            <a href="{{ $baseURL . '&format=csv' }}" target="_blank" class="dropdown-item">CSV</a>
            <a href="{{ $baseURL . '&format=ods' }}" target="_blank" class="dropdown-item">ODS</a>
        </div>
    </div>
</div>
