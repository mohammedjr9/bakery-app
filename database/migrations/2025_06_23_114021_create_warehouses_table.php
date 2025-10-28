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
        Schema::create('warehouses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('location')->nullable();
            $table->unsignedBigInteger('type_coupon_id')->nullable();
            $table->integer('total_packages')->default(0);
            $table->integer('remaining_packages')->default(0);
            $table->timestamps();
            $table->foreign('type_coupon_id')->references('id')->on('type_coupons')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('warehouses');
    }
};
