<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Throwable;

class OrderActivityLogModel extends Model
{
    use HasFactory;

    protected $table = 'order_activity_logs';

    protected $fillable = [
        'order_id',
        'user_id',
        'action',
        'description',
        'old_value',
        'new_value',
    ];

    /**
     * ترجمة أكواد النشاطات إلى نص عربي مفهوم للمستخدم.
     */
    public const ACTION_LABELS = [
        'create_order'                     => 'إنشاء طلبية',
        'delete_order'                     => 'حذف طلبية',
        'update_status'                    => 'تغيير حالة الطلبية',
        'update_due_date'                  => 'تعديل تاريخ الطلبية',
        'update_production_date'           => 'تعديل تاريخ الإنتاج',
        'update_ref_number'                => 'تعديل الرقم المرجعي',
        'update_to_user'                   => 'تعيين موظف للمتابعة',
        'add_item'                         => 'إضافة صنف',
        'delete_item'                      => 'حذف صنف',
        'update_qty'                       => 'تعديل الكمية',
        'update_unit'                      => 'تعديل الوحدة',
        'add_product'                      => 'إضافة صنف للطلبية',
        'update_product_note'              => 'تعديل ملاحظات الصنف',
        'add_product_attachment'           => 'إضافة مرفق للأصناف',
        'delete_product_attachment'        => 'حذف مرفق الأصناف',
        'add_comment'                      => 'إضافة ملاحظة',
        'add_order_note'                   => 'إضافة ملاحظة للطلبية',
        'update_order_note'                => 'تعديل ملاحظة الطلبية',
        'delete_order_note'                => 'حذف ملاحظة الطلبية',
        'add_order_attachment'             => 'إضافة مرفق للطلبية',
        'delete_order_attachment'          => 'حذف مرفق الطلبية',
        'add_price_offer'                  => 'إضافة عرض سعر',
        'update_price_offer'               => 'تعديل عرض سعر',
        'delete_price_offer'               => 'حذف عرض سعر',
        'update_price_offer_note'          => 'تعديل ملاحظات عرض السعر',
        'add_price_offer_item'             => 'إضافة سعر لصنف',
        'update_price_offer_item'          => 'تعديل سعر صنف',
        'add_bonus'                        => 'إضافة علاوة',
        'update_bonus'                     => 'تعديل علاوة',
        'add_discount'                     => 'إضافة خصم',
        'update_discount'                  => 'تعديل خصم',
        'update_currency'                  => 'تعديل العملة',
        'import_price_offer'               => 'استيراد أسعار من Excel',
        'add_anchor'                       => 'ترسية عرض سعر',
        'delete_anchor'                    => 'إلغاء الترسية',
        'update_anchor_note'               => 'تعديل ملاحظات الترسية',
        'upload_anchor_attachment'         => 'رفع مرفق للترسية',
        'delete_anchor_attachment'         => 'حذف مرفق الترسية',
        'add_cash_payment'                 => 'إضافة دفعة نقدية',
        'update_cash_payment'              => 'تعديل دفعة نقدية',
        'delete_cash_payment'              => 'حذف دفعة نقدية',
        'update_payment_status'            => 'تحديث حالة الدفعة',
        'delete_payment_status'            => 'التراجع عن تسديد دفعة',
        'add_letter_bank'                  => 'إضافة اعتماد مستندي',
        'update_letter_bank'               => 'تعديل اعتماد مستندي',
        'delete_letter_bank'               => 'حذف اعتماد مستندي',
        'paid_letter_bank'                 => 'تسديد اعتماد مستندي',
        'update_paid_letter_bank'          => 'تعديل تسديد اعتماد مستندي',
        'delete_paid_letter_bank'          => 'التراجع عن تسديد اعتماد',
        'add_letter_bank_extension'        => 'إضافة تمديد اعتماد',
        'update_letter_bank_extension'     => 'تعديل تمديد اعتماد',
        'delete_letter_bank_extension'     => 'حذف تمديد اعتماد',
        'add_shipping_offer'               => 'إضافة عرض شحن',
        'update_shipping_offer'            => 'تعديل عرض شحن',
        'delete_shipping_offer'            => 'حذف عرض شحن',
        'add_shipping_award'               => 'ترسية شحن',
        'cancel_shipping_award'            => 'إلغاء ترسية الشحن',
        'update_shipping_award'            => 'تعديل ترسية الشحن',
        'update_shipping_note'             => 'تعديل ملاحظات الشحن',
        'update_shipping_status'           => 'تغيير حالة الشحن',
        'add_insurance'                    => 'إضافة تأمين',
        'update_insurance'                 => 'تعديل التأمين',
        'delete_insurance'                 => 'حذف التأمين',
        'update_insurance_note'            => 'تعديل ملاحظات التأمين',
        'add_clearance'                    => 'إضافة تخليص',
        'update_clearance_status'          => 'تغيير حالة التخليص',
        'update_clearance_note'            => 'تعديل ملاحظات التخليص',
        'delete_clearance'                 => 'حذف التخليص',
        'add_clearance_attachment'         => 'إضافة مرفق تخليص',
        'update_clearance_attachment_file' => 'تعديل مرفق التخليص',
        'delete_clearance_attachment'      => 'حذف مرفق التخليص',
        'delete_clearance_attachment_file' => 'تفريغ ملف مرفق التخليص',
        'add_delivery'                     => 'إضافة توصيل',
        'update_delivery'                  => 'تعديل التوصيل',
        'delete_delivery'                  => 'حذف التوصيل',
        'update_delivery_note'             => 'تعديل ملاحظات التوصيل',
        'add_delivery_item'                => 'إضافة تكلفة توصيل',
        'delete_delivery_item'             => 'حذف تكلفة توصيل',
        'update_delivery_item_price'       => 'تسعير تكلفة التوصيل',
        'export_product_supplier_pdf'      => 'تصدير نموذج عرض سعر',
        'export_order_summary_pdf'         => 'تصدير ملخص الطلبية',
        'export_product_list_pdf'          => 'تصدير قائمة الأصناف',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function order()
    {
        return $this->belongsTo(OrderModel::class, 'order_id');
    }

    /**
     * اسم النشاط بالعربي، ويرجع الكود نفسه إذا لم تكن له ترجمة.
     */
    public function getActionLabelAttribute(): string
    {
        return self::ACTION_LABELS[$this->action] ?? $this->action;
    }

    public static function logActivity($order_id, $action, $description = null, $old_value = null, $new_value = null)
    {
        // بدون رقم طلبية لا معنى للسجل، وتخزينه بالرقم 0 يخفي الحركة عن كل الطلبيات.
        if (empty($order_id)) {
            Log::warning('order activity log skipped: missing order_id', ['action' => $action]);
            return null;
        }

        try {
            return self::create([
                'order_id'    => $order_id,
                'user_id'     => auth()->check() ? auth()->id() : null,
                'action'      => $action,
                'description' => $description,
                'old_value'   => is_null($old_value) ? null : (string) $old_value,
                'new_value'   => is_null($new_value) ? null : (string) $new_value,
            ]);
        } catch (Throwable $e) {
            // فشل التسجيل يجب ألا يوقف العملية الأساسية (حفظ/تعديل/حذف)،
            // لكن السبب الحقيقي يُكتب في storage/logs/laravel.log.
            Log::error('order activity log failed: ' . $e->getMessage(), [
                'order_id' => $order_id,
                'action'   => $action,
            ]);
            return null;
        }
    }
}
