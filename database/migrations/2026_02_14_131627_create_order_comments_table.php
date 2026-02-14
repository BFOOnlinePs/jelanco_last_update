<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_comments', function (Blueprint $table) {
            $table->id();
            $table->text('comment');
            $table->string('type')->default('general');
            $table->timestamps();

            // 1. للطلبات: integer (لأننا تأكدنا أنه int(11))
            $table->integer('order_id');
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');

            // 2. للمستخدمين: unsignedBigInteger (هذا هو التغيير)
            // غالباً جدول users في لارافل يكون BigInteger Unsigned
            $table->unsignedBigInteger('user_id'); 
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_comments');
    }
};