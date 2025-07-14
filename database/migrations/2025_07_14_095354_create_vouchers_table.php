<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->string('code', 50)->unique(); // Unique voucher code
            $table->string('name', 100)->nullable(); // Optional name
            $table->longText('description')->nullable(); // Optional description
            $table->enum('type', ['percentage', 'fixed']); // Discount type
            $table->decimal('value', 10, 2); // Discount value
            $table->decimal('min_spend', 10, 2)->nullable(); // Min spend to use voucher
            $table->integer('usage_limit')->nullable(); // Max total uses
            $table->integer('per_user_limit')->nullable(); // Max per user uses
            $table->dateTime('start_date')->nullable(); // Start date of voucher
            $table->dateTime('expiry_date')->nullable(); // End date of voucher
            $table->boolean('is_active')->default(true); // Active or not
            $table->timestamps(); // created_at and updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vouchers');
    }
};
