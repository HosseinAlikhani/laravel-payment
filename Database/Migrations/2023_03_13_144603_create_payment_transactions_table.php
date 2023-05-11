<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use D3cr33\Payment\Models\Transaction;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payment_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id');
            $table->morphs('model');
            $table->string('tracking_code');
            $table->integer('module');
            $table->integer('amount');
            $table->text('description')->nullable();
            $table->integer('port');
            $table->enum('status', [
                Transaction::STATUS_INIT,
                Transaction::STATUS_SUCCEED,
                Transaction::STATUS_FAILED
            ]);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_transactions');
    }
};
