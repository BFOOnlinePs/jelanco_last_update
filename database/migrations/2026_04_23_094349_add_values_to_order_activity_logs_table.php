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
        Schema::table('order_activity_logs', function (Blueprint $table) {
            // الأعمدة تُضاف فقط إذا كانت مفقودة، حتى تعمل الهجرة أيضاً على
            // قواعد البيانات التي أُنشئ فيها الجدول يدوياً.
            if (! Schema::hasColumn('order_activity_logs', 'old_value')) {
                $table->text('old_value')->nullable()->after('description');
            }
            if (! Schema::hasColumn('order_activity_logs', 'new_value')) {
                $table->text('new_value')->nullable()->after('old_value');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_activity_logs', function (Blueprint $table) {
            $table->dropColumn(['old_value', 'new_value']);
        });
    }
};
