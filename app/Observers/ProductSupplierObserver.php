<?php

namespace App\Observers;

use App\Models\ProductActivityLogModel;
use App\Models\ProductSupplierModel;
use App\Models\User;

class ProductSupplierObserver
{
    public function created(ProductSupplierModel $row): void
    {
        ProductActivityLogModel::logActivity(
            $row->product_id,
            'add_supplier',
            'تم ربط المنتج بالمورد: ' . $this->supplierName($row),
            null,
            null,
            $this->supplierName($row)
        );
    }

    public function deleted(ProductSupplierModel $row): void
    {
        ProductActivityLogModel::logActivity(
            $row->product_id,
            'delete_supplier',
            'تم فك ارتباط المنتج بالمورد: ' . $this->supplierName($row),
            null,
            $this->supplierName($row),
            null
        );
    }

    private function supplierName(ProductSupplierModel $row): string
    {
        return optional(User::find($row->user_id))->name ?? 'غير معروف';
    }
}
