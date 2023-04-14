<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use D3cr33\Payment\Models\GatewayTransaction;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payment_gateway_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('transaction_id');
            $table->integer('port');
            $table->integer('amount');
            $table->string('ref_id')->nullable();
            $table->string('tracking_code');
            $table->string('card_number')->nullable();
            $table->enum('status',[
                GatewayTransaction::STATUS_INIT,
                GatewayTransaction::STATUS_SUCCEED,
                GatewayTransaction::STATUS_FAILED
            ]);
            $table->string('ip')->nullable();
            $table->text('description')->nullable();
            $table->timestamp('payment_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_gateway_transactions');
    }
};
