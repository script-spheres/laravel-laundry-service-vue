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
        Schema::create('delivery_scales', function (Blueprint $table) {
            $table->id();
            $table->decimal('radius', 10, 2)->default(0.00);
            $table->enum('radius_unit', ['km', 'miles'])->default('km');
            $table->decimal('min_order_amount', 10, 2)->default(0.00);
            $table->decimal('delivery_charges', 10, 2)->default(0.00);
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delivery_scales');
    }
};
