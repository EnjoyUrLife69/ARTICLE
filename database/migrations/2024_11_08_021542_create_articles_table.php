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
        Schema::create('articles', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title');
            $reselease_date = $table->date('release_date');
            $table->uuid('categorie_id');
            $table->unsignedBigInteger('user_id');
            $table->string('cover')->nullable();
            $table->longtext('description');
            $table->longtext('content');
            $table->enum('status', ['approved', 'pending', 'rejected'])->default('pending');
            $table->unsignedBigInteger('view_count')->default(0);
            $table->unsignedBigInteger('share_count')->default(0);
            $table->unsignedBigInteger('like_count')->default(0);
            $table->timestamps();

            $table->foreign('categorie_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
