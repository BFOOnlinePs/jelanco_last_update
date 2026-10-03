<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // اسم ملف شعار الشركة داخل storage/app/public/system_setting، وفارغ يعني الشعار الافتراضي
        if (! Schema::hasColumn('system_setting', 'company_logo')) {
            Schema::table('system_setting', function (Blueprint $table) {
                $table->string('company_logo')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('system_setting', 'company_logo')) {
            Schema::table('system_setting', function (Blueprint $table) {
                $table->dropColumn('company_logo');
            });
        }
    }
};
