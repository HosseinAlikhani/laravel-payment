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
        Schema::create('gateway_transaction_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('gateway_transaction_id');
            $table->string('result_status');
            $table->string('result_message');
            $table->timestamp('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gateway_transaction_logs');
    }
};
