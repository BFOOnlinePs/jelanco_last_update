<?php

namespace App\Providers;

use App\Models\OrderItemsModel;
use App\Models\ProductModel;
use App\Models\ProductNotesModel;
use App\Models\ProductSupplierModel;
use App\Observers\OrderItemProductObserver;
use App\Observers\ProductNoteObserver;
use App\Observers\ProductObserver;
use App\Observers\ProductSupplierObserver;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Registration any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();

        // سجل نشاطات المنتجات: مربوط بأحداث الموديلات نفسها ليغطي أي مصدر
        // للتعديل (شاشة الأصناف، شاشة الطلبيات، استيراد Excel، ...).
        ProductModel::observe(ProductObserver::class);
        ProductNotesModel::observe(ProductNoteObserver::class);
        ProductSupplierModel::observe(ProductSupplierObserver::class);
        OrderItemsModel::observe(OrderItemProductObserver::class);
    }
}
