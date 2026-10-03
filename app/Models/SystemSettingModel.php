<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class SystemSettingModel extends Model
{
    use HasFactory;

    protected $table = 'system_setting';

    // الشعار المستخدم عندما لا يتم رفع شعار من إعدادات النظام
    public const DEFAULT_LOGO = 'img/jelanco.png';

    // مجلد الشعار المرفوع داخل قرص public
    public const LOGO_DIR = 'system_setting';

    protected static $currentRow;

    // صف الإعدادات الوحيد، يُقرأ مرة واحدة في كل طلب حتى لا يتكرر الاستعلام في كل قالب
    public static function current()
    {
        return static::$currentRow ??= static::first();
    }

    public static function hasCustomLogo(): bool
    {
        $logo = optional(static::current())->company_logo;

        return ! empty($logo) && Storage::disk('public')->exists(self::LOGO_DIR . '/' . $logo);
    }

    public static function logoUrl(): string
    {
        if (static::hasCustomLogo()) {
            return asset('storage/' . self::LOGO_DIR . '/' . static::current()->company_logo);
        }

        return asset(self::DEFAULT_LOGO);
    }
}
