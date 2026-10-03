{{--
    صورة الصنف المصغرة داخل الجداول، مع معاينة مكبرة عند المرور (التنسيق في theme.css والسكربت في home.blade.php)
    الاستخدام: <x-product-thumb :photo="$product->product_photo" :name="$product->product_name_ar" />
    size="sm" للجداول المضغوطة، وأي خصائص إضافية (onclick, data-toggle...) تنتقل للعنصر نفسه
--}}
@props(['photo' => null, 'name' => '', 'size' => null])
@php
    $url = empty($photo) ? null : asset('storage/product/' . $photo);
    $classes = 'jl-thumb' . ($size === 'sm' ? ' jl-thumb--sm' : '') . ($url ? '' : ' jl-thumb--empty');
@endphp
<span {{ $attributes->merge(['class' => $classes]) }}
      @if ($url) tabindex="0" data-preview="{{ $url }}" data-caption="{{ $name }}" @else title="لا توجد صورة" @endif>
    @if ($url)
        {{-- إذا كان ملف الصورة غير موجود على السيرفر نعرض حالة "بدون صورة" بدل أيقونة الصورة المكسورة --}}
        <img src="{{ $url }}" alt="{{ $name }}" loading="lazy"
             onerror="var t=this.parentNode;t.classList.add('jl-thumb--empty');t.removeAttribute('data-preview');t.removeAttribute('tabindex');this.remove()">
    @endif
    <span class="fa fa-image jl-thumb__fallback" aria-hidden="true"></span>
</span>
