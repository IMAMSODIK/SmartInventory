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
            $table->string('order_id')->unique();
            $table->foreignId('buyer_id')->constrained('users');
            $table->foreignId('alamat_id')->constrained();

            $table->enum('status', [
                'pending',
                'paid',
                'processing',
                'shipping',
                'delivered',
                'cancelled',
                'complaint',
                'challenge',
                'deny',
                'expired'
            ])->default('pending');

            $table->decimal('shipping_cost', 12, 2);
            $table->decimal('total', 12, 2);

            $table->string('payment_type')->nullable();
            $table->string('transaction_id')->nullable();
            $table->string('fraud_status')->nullable();
            $table->boolean('is_reviewed')->default(false);
            $table->timestamps();
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
