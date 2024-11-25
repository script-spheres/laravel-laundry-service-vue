<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('quantity');
            $table->string('price');
            $table->string('subtotal');
            $table->string('restaurant_notes')->nullable();
            $table->string('request_notes')->nullable();
            $table->enum('serve_status', ['placed', 'offline'])->nullable()->default('placed');
            $table->enum('kitchen_status', ['pending', 'processing', 'completed', 'cancel', 'reject'])->nullable()->default('pending');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_details');
    }
};
