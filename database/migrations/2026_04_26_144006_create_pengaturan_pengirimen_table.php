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
        Schema::create('pengaturan_pengirimen', function (Blueprint $table) {
            $table->id();
            $table->decimal('base_cost_per_km', 12, 2)->default(2000);

            $table->decimal('min_order_multiplier', 5, 2)->default(2); 
            // minimal order = 2x ongkir
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengaturan_pengirimen');
    }
};
