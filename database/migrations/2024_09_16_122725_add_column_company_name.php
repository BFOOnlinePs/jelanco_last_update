<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (! Schema::hasColumn('system_setting', 'company_name')) {
            // ملاحظة: عمود TEXT في MySQL لا يقبل قيمة افتراضية، لذلك يتم ضبط
            // الاسم الافتراضي من الكود وليس من قاعدة البيانات.
            Schema::table('system_setting', function (Blueprint $table) {
                $table->text('company_name')->nullable();
            });
        }

        // كان هذا السطر يستخدم ->change() الذي يتطلب حزمة doctrine/dbal غير
        // المثبتة في المشروع، فكان يفشل ويوقف تنفيذ كل الهجرات التي بعده.
        if (DB::connection()->getDriverName() === 'mysql' && Schema::hasColumn('system_setting', 'updated_at')) {
            DB::statement('ALTER TABLE `system_setting` MODIFY `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('system_setting', function (Blueprint $table) {
            //
        });
    }
};
