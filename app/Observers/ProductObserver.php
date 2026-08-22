<?php

namespace App\Observers;

use App\Models\ProductActivityLogModel;
use App\Models\ProductModel;

/**
 * يلتقط أي تعديل على المنتجات مهما كان مصدره (شاشة الأصناف، شاشة الطلبيات،
 * استيراد Excel، أو أي كود جديد يُضاف لاحقاً) لأنه مربوط بأحداث الموديل نفسه.
 */
class ProductObserver
{
    public function created(ProductModel $product): void
    {
        ProductActivityLogModel::logActivity(
            $product->id,
            'create_product',
            'تم إضافة المنتج: ' . ($product->product_name_ar ?: $product->product_name_en)
        );
    }

    public function updated(ProductModel $product): void
    {
        $changes = $product->getChanges();

        foreach ($changes as $field => $newValue) {
            if (in_array($field, ProductActivityLogModel::IGNORED_FIELDS, true)) {
                continue;
            }

            $oldValue = $product->getOriginal($field);

            // تجاهل التغييرات الشكلية (مثل "5" مقابل 5)
            if ((string) $oldValue === (string) $newValue) {
                continue;
            }

            $label = ProductActivityLogModel::FIELD_LABELS[$field] ?? $field;

            if ($field === 'product_photo') {
                $action = $newValue === null ? 'delete_photo' : 'upload_photo';
                $description = $newValue === null ? 'تم حذف صورة المنتج' : 'تم رفع صورة جديدة للمنتج';
            } else {
                $action = 'update_product';
                $description = 'تم تعديل ' . $label;
            }

            ProductActivityLogModel::logActivity(
                $product->id,
                $action,
                $description,
                $field,
                $oldValue,
                $newValue
            );
        }
    }

    public function deleted(ProductModel $product): void
    {
        ProductActivityLogModel::logActivity(
            $product->id,
            'delete_product',
            'تم حذف المنتج: ' . ($product->product_name_ar ?: $product->product_name_en)
        );
    }

    public function restored(ProductModel $product): void
    {
        ProductActivityLogModel::logActivity(
            $product->id,
            'restore_product',
            'تم استرجاع المنتج: ' . ($product->product_name_ar ?: $product->product_name_en)
        );
    }
}
