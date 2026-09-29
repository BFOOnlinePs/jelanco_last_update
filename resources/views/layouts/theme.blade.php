{{-- Design system: resources/css/theme.css is inlined so it ships with the code (public/ is not in git). --}}
@once
    <style id="jelanco-theme">{!! file_get_contents(resource_path('css/theme.css')) !!}</style>
@endonce
