@php
    $jlProductTiles = [
        ['قائمة الأصناف', $product_count ?? null, 'fa-boxes-stacked', 'product.index', ['product.index', 'product.add', 'product.edit', 'product.details']],
        ['مجموعات الأصناف', $category_count ?? null, 'fa-layer-group', 'category.index', ['category.*']],
        ['الوحدات', $unit_count ?? null, 'fa-ruler-combined', 'units.index', ['units.*']],
        ['سجل نشاطات الأصناف', 'كل التعديلات والحذف', 'fa-clock-rotate-left', 'product.activity_logs', ['product.activity_logs']],
    ];
@endphp
<nav class="row" aria-label="أقسام الأصناف">
    @foreach ($jlProductTiles as [$jlTitle, $jlMeta, $jlIcon, $jlRoute, $jlPatterns])
        @php
            $jlCurrent = request()->routeIs(...$jlPatterns);
        @endphp
        <div class="col-xl-3 col-sm-6">
            <a href="{{ route($jlRoute) }}" class="jl-tile {{ $jlCurrent ? 'is-active' : '' }}" @if ($jlCurrent) aria-current="page" @endif>
                <span class="jl-tile__icon" aria-hidden="true"><i class="fas {{ $jlIcon }}"></i></span>
                <span class="jl-tile__body">
                    <span class="jl-tile__title">{{ $jlTitle }}</span>
                    @if (!is_numeric($jlMeta) && $jlMeta)
                        <span class="jl-tile__desc">{{ $jlMeta }}</span>
                    @endif
                </span>
                @if (is_numeric($jlMeta))
                    <span class="jl-tile__meta">{{ number_format($jlMeta) }}</span>
                @endif
            </a>
        </div>
    @endforeach
</nav>
