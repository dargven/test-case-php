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
            $table->integer('id', true)->unique('orders_pk_2');
            $table->integer('event_id')->unique('orders_pk_3');
            $table->string('event_date', 210);
            $table->integer('ticket_adult_price');
            $table->integer('ticket_adult_quantity');
            $table->integer('ticket_kid_price');
            $table->integer('ticket_kid_quantity');
            $table->integer('user_id');
            $table->string('barcode', 120);
            $table->integer('equal_price')->comment('Общая сумма заказа');
            $table->dateTime('created')->nullable();

            $table->primary(['id']);
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
