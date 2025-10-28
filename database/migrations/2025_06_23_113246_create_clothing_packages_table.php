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
        Schema::create('clothing_packages', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('name');
            $table->integer('id_num');
            $table->date('due_date');
            $table->dateTime('receipt_date')->nullable();
            $table->integer('children_count');
            $table->decimal('amount', 10, 2);
            $table->foreignId('distribution_place_id')->nullable()->constrained('constants')->nullOnDelete();
            $table->text('notes')->nullable();
            $table->foreignId('update_user_id')->nullable()
                ->constrained('users')
                ->nullOnDelete();
            $table->foreignId('project_id')->nullable()->constrained('constants')->nullOnDelete();

            $table->timestamps();

            $table->unique(['name', 'id_num', 'due_date'], 'unique_name_id_due');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clothing_packages');
    }
};
