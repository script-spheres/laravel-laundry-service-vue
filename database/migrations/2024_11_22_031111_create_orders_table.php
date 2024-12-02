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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->uuid('order_uuid');
            $table->foreignId('customer_id')->constrained('customers')->cascadeOnDelete();
            $table->foreignId('store_id')->constrained('stores')->cascadeOnDelete();
            $table->decimal('total_weight_kg', 5, 2)->default(0);
            $table->decimal('sub_total', 5, 2)->default(0);
            $table->decimal('total_price', 5, 2)->default(0);
            $table->decimal('tax', 5, 2)->default(0);
            $table->decimal('discount', 5, 2)->default(0);
            $table->decimal('paid_amount', 5, 2)->default(0);
            $table->date('delivery_date');
            $table->text('quick_note')->nullable();
            $table->enum('order_status', ['pending', 'in-progress', 'ready-to-deliver', 'delivered'])->default('pending');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
