<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('withdraws', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->unsignedBigInteger('user_id');
            $table->decimal('amount', 10, 2);
            $table->enum('payment_method', ['bank_transfer', 'e-wallet']);

            // Bank transfer details
            $table->string('bank_name')->nullable();
            $table->string('account_number')->nullable();
            $table->string('account_name')->nullable();

            // E-wallet details
            $table->string('ewallet_type')->nullable();
            $table->string('phone_number')->nullable();

            // Status langsung menjadi completed
            $table->enum('status', ['completed'])->default('completed');
            $table->timestamp('processed_at')->useCurrent();
            $table->text('notes')->nullable();

            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('withdraws');
    }
};
