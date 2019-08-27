@if( App::isLocale('tw'))
    <div class="d-flex justify-content-between flex-column flex-md-row small text-secondary mb-2">{{ $slot }}</div>
@endif
