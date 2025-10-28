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
        Schema::create('beneficiaries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('id_num')->nullable();
            $table->date('due_date');
            $table->dateTime('receipt_date')->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('type_coupon_id')->nullable()
                ->constrained('type_coupons')
                ->nullOnDelete();
            $table->foreignId('update_user_id')->nullable()
                ->constrained('users')
                ->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('beneficiaries');
    }
};
