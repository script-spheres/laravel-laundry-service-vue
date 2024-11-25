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
            $table->string('radius');
            $table->string('min_order_amount');
            $table->string('delivery_charges');
            $table->string('min_order_free_delivery');
            $table->enum('active_status', ['active', 'inactive']);
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
