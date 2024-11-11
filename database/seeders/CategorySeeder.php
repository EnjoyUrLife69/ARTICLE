<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Menambahkan data kategori dengan deskripsi
        DB::table('categories')->insert([
            [
                'id' => (string) Str::uuid(), // Menambahkan UUID
                'name' => 'Technology',
                'description' => 'Kategori ini mencakup berbagai artikel tentang teknologi terbaru, inovasi, dan perkembangan digital.',
            ],
            [
                'id' => (string) Str::uuid(),
                'name' => 'Health',
                'description' => 'Kategori ini berisi artikel-artikel tentang kesehatan, gaya hidup sehat, dan tips medis.',
            ],
            [
                'id' => (string) Str::uuid(),
                'name' => 'Lifestyle',
                'description' => 'Kategori ini mencakup artikel tentang gaya hidup, hobi, perjalanan, dan budaya populer.',
            ],
            [
                'id' => (string) Str::uuid(),
                'name' => 'Business',
                'description' => 'Kategori ini berisi artikel tentang dunia bisnis, strategi pemasaran, dan perkembangan ekonomi.',
            ],
            [
                'id' => (string) Str::uuid(),
                'name' => 'Education',
                'description' => 'Kategori ini berisi artikel-artikel yang membahas pendidikan, pengajaran, dan perkembangan ilmu pengetahuan.',
            ],
            // Tambahkan kategori lain sesuai kebutuhan
        ]);
    }
}
