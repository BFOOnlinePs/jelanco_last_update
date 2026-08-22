<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Throwable;

class ProductActivityLogModel extends Model
{
    use HasFactory;

    protected $table = 'product_activity_logs';

    protected $fillable = [
        'product_id',
        'user_id',
        'action',
        'description',
        'field',
        'old_value',
        'new_value',
    ];

    /**
     * أنواع الحركات على المنتج.
     */
    public const ACTION_LABELS = [
        'create_product'         => 'إضافة منتج',
        'update_product'         => 'تعديل بيانات المنتج',
        'delete_product'         => 'حذف منتج',
        'restore_product'        => 'استرجاع منتج',
        'import_products'        => 'استيراد منتجات من Excel',
        'upload_photo'           => 'رفع صورة المنتج',
        'delete_photo'           => 'حذف صورة المنتج',
        'add_supplier'           => 'إضافة مورد للمنتج',
        'delete_supplier'        => 'حذف مورد من المنتج',
        'add_note'               => 'إضافة ملاحظة للمنتج',
        'delete_note'            => 'حذف ملاحظة من المنتج',
        'add_to_order'           => 'إضافة المنتج لطلبية',
        'remove_from_order'      => 'حذف المنتج من طلبية',
    ];

    /**
     * أسماء حقول جدول المنتجات بالعربي.
     */
    public const FIELD_LABELS = [
        'product_name_ar' => 'اسم الصنف بالعربي',
        'product_name_en' => 'اسم الصنف بالانجليزي',
        'category_id'     => 'تصنيف المنتج',
        'unit_id'         => 'الوحدة',
        'barcode'         => 'الباركود',
        'less_qty'        => 'أقل كمية',
        'certified'       => 'معتمد / غير معتمد',
        'product_status'  => 'حالة المنتج',
        'product_price'   => 'سعر المنتج',
        'product_photo'   => 'صورة المنتج',
        'product_id'      => 'رقم الصنف',
    ];

    /**
     * الحقول التي لا فائدة من تسجيل تغيّرها.
     */
    public const IGNORED_FIELDS = [
        'id',
        'created_at',
        'updated_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function product()
    {
        return $this->belongsTo(ProductModel::class, 'product_id');
    }

    public function getActionLabelAttribute(): string
    {
        return self::ACTION_LABELS[$this->action] ?? $this->action;
    }

    public function getFieldLabelAttribute(): ?string
    {
        if (empty($this->field)) {
            return null;
        }

        return self::FIELD_LABELS[$this->field] ?? $this->field;
    }

    /**
     * تحويل القيمة المخزّنة إلى نص مقروء (اسم التصنيف بدل رقمه مثلاً).
     */
    public static function displayValue(?string $field, $value): string
    {
        if ($value === null || $value === '') {
            return 'فارغ';
        }

        if ($field === 'category_id') {
            return optional(CategoryProductModel::find($value))->cat_name ?? (string) $value;
        }

        if ($field === 'unit_id') {
            return optional(UnitsModel::find($value))->unit_name ?? (string) $value;
        }

        if ($field === 'product_status') {
            return $value == 1 ? 'مفعل' : 'موقوف';
        }

        if ($field === 'certified') {
            return $value == 1 ? 'معتمد' : 'غير معتمد';
        }

        return (string) $value;
    }

    public function getOldValueTextAttribute(): string
    {
        return self::displayValue($this->field, $this->old_value);
    }

    public function getNewValueTextAttribute(): string
    {
        return self::displayValue($this->field, $this->new_value);
    }

    /**
     * تسجيل حركة على منتج. لا يرمي استثناء حتى لا توقف العملية الأساسية.
     */
    public static function logActivity(
        $product_id,
        string $action,
        ?string $description = null,
        ?string $field = null,
        $old_value = null,
        $new_value = null
    ) {
        if (empty($product_id)) {
            Log::warning('product activity log skipped: missing product_id', ['action' => $action]);
            return null;
        }

        try {
            return self::create([
                'product_id'  => $product_id,
                'user_id'     => auth()->check() ? auth()->id() : null,
                'action'      => $action,
                'description' => $description,
                'field'       => $field,
                'old_value'   => is_null($old_value) ? null : (string) $old_value,
                'new_value'   => is_null($new_value) ? null : (string) $new_value,
            ]);
        } catch (Throwable $e) {
            Log::error('product activity log failed: ' . $e->getMessage(), [
                'product_id' => $product_id,
                'action'     => $action,
            ]);
            return null;
        }
    }
}
