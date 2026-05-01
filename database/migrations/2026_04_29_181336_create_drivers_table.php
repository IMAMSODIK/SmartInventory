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
        Schema::create('drivers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            $table->string('vehicle_type')->nullable();
            $table->string('plate_number')->nullable();

            $table->double('latitude')->nullable();
            $table->double('longitude')->nullable();

            $table->boolean('is_online')->default(false); // 🔥 status aktif
            $table->boolean('is_available')->default(true); // 🔥 siap ambil order

            $table->decimal('rating', 3, 2)->default(0);
            $table->integer('total_delivery')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('drivers');
    }
};
