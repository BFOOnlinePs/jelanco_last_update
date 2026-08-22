<?php

namespace App\Observers;

use App\Models\OrderItemsModel;
use App\Models\ProductActivityLogModel;

/**
 * يسجّل في سجل المنتج دخوله/خروجه من الطلبيات، حتى يظهر في صفحة المنتج
 * تاريخ استخدامه الكامل وليس التعديلات على بياناته فقط.
 */
class OrderItemProductObserver
{
    public function created(OrderItemsModel $item): void
    {
        ProductActivityLogModel::logActivity(
            $item->product_id,
            'add_to_order',
            'تم إضافة المنتج للطلبية رقم ' . $item->order_id,
            null,
            null,
            $item->qty
        );
    }

    public function deleted(OrderItemsModel $item): void
    {
        ProductActivityLogModel::logActivity(
            $item->product_id,
            'remove_from_order',
            'تم حذف المنتج من الطلبية رقم ' . $item->order_id,
            null,
            $item->qty,
            null
        );
    }
}
