<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('likes', function (Blueprint $table) {
            $table->dropPrimary();    // Hapus primary key lama
            $table->dropColumn('id'); // Hapus kolom id lama
        });

        Schema::table('likes', function (Blueprint $table) {
            $table->uuid('id')->primary(); // Tambahkan kolom id baru sebagai UUID
        });
    }

    public function down(): void
    {
        Schema::table('likes', function (Blueprint $table) {
            $table->dropPrimary();
            $table->dropColumn('id');
        });

        Schema::table('likes', function (Blueprint $table) {
            $table->id(); // Tambahkan kembali id auto-increment jika rollback
        });
    }
};

