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
            [
                'id' => (string) Str::uuid(),
                'name' => 'Sports',
                'description' => 'Kategori ini mencakup berita olahraga, tips kebugaran, dan pembahasan kompetisi olahraga.',
            ],
            [
                'id' => (string) Str::uuid(),
                'name' => 'Travel',
                'description' => 'Kategori ini berisi artikel tentang destinasi wisata, tips perjalanan, dan pengalaman menarik.',
            ],
            [
                'id' => (string) Str::uuid(),
                'name' => 'Food',
                'description' => 'Kategori ini mencakup resep masakan, ulasan kuliner, dan tips memasak.',
            ],
            [
                'id' => (string) Str::uuid(),
                'name' => 'Fashion',
                'description' => 'Kategori ini berisi artikel tentang tren mode, tips berpakaian, dan gaya terbaru.',
            ],
            [
                'id' => (string) Str::uuid(),
                'name' => 'Entertainment',
                'description' => 'Kategori ini mencakup berita tentang film, musik, acara TV, dan dunia hiburan.',
            ],
            [
                'id' => (string) Str::uuid(),
                'name' => 'Science',
                'description' => 'Kategori ini berisi pembahasan tentang penemuan ilmiah, teknologi sains, dan eksplorasi luar angkasa.',
            ],
            [
                'id' => (string) Str::uuid(),
                'name' => 'Environment',
                'description' => 'Kategori ini mencakup artikel tentang lingkungan hidup, perubahan iklim, dan tips ramah lingkungan.',
            ],
            [
                'id' => (string) Str::uuid(),
                'name' => 'Finance',
                'description' => 'Kategori ini membahas keuangan pribadi, investasi, dan manajemen uang.',
            ],
            [
                'id' => (string) Str::uuid(),
                'name' => 'Parenting',
                'description' => 'Kategori ini berisi tips mengasuh anak, pendidikan keluarga, dan hubungan orang tua-anak.',
            ],
            [
                'id' => (string) Str::uuid(),
                'name' => 'Photography',
                'description' => 'Kategori ini mencakup teknik fotografi, ulasan alat fotografi, dan tips editing foto.',
            ],
            [
                'id' => (string) Str::uuid(),
                'name' => 'Art',
                'description' => 'Kategori ini membahas karya seni, teknik melukis, dan tren seni kontemporer.',
            ],
            [
                'id' => (string) Str::uuid(),
                'name' => 'Automotive',
                'description' => 'Kategori ini berisi artikel tentang mobil, motor, teknologi otomotif, dan tips perawatan kendaraan.',
            ],
            [
                'id' => (string) Str::uuid(),
                'name' => 'Gaming',
                'description' => 'Kategori ini mencakup berita game, ulasan game, dan tips bermain.',
            ],
            [
                'id' => (string) Str::uuid(),
                'name' => 'History',
                'description' => 'Kategori ini berisi pembahasan sejarah, peristiwa penting, dan tokoh-tokoh bersejarah.',
            ],
            [
                'id' => (string) Str::uuid(),
                'name' => 'Books',
                'description' => 'Kategori ini mencakup ulasan buku, rekomendasi bacaan, dan berita literasi.',
            ],
            [
                'id' => (string) Str::uuid(),
                'name' => 'Technology Reviews',
                'description' => 'Kategori ini berisi ulasan tentang gadget, software, dan perangkat teknologi lainnya.',
            ],
            [
                'id' => (string) Str::uuid(),
                'name' => 'Fitness',
                'description' => 'Kategori ini mencakup latihan kebugaran, tips workout, dan program diet.',
            ],
            [
                'id' => (string) Str::uuid(),
                'name' => 'Movies',
                'description' => 'Kategori ini berisi ulasan film, berita perfilman, dan rekomendasi tontonan.',
            ],
            [
                'id' => (string) Str::uuid(),
                'name' => 'DIY',
                'description' => 'Kategori ini mencakup tutorial DIY, proyek kreatif, dan ide kerajinan tangan.',
            ],
            [
                'id' => (string) Str::uuid(),
                'name' => 'Relationships',
                'description' => 'Kategori ini berisi tips hubungan, pengembangan diri, dan diskusi tentang kehidupan cinta.',
            ],
            [
                'id' => (string) Str::uuid(),
                'name' => 'Career',
                'description' => 'Kategori ini membahas tips karir, pengembangan profesional, dan peluang kerja.',
            ],
            [
                'id' => (string) Str::uuid(),
                'name' => 'Pets',
                'description' => 'Kategori ini mencakup tips merawat hewan peliharaan, kesehatan hewan, dan cerita tentang hewan.',
            ],
            [
                'id' => (string) Str::uuid(),
                'name' => 'Real Estate',
                'description' => 'Kategori ini membahas properti, investasi real estate, dan tips membeli rumah.',
            ],
            [
                'id' => (string) Str::uuid(),
                'name' => 'Music',
                'description' => 'Kategori ini mencakup berita musik, ulasan album, dan diskusi tentang dunia musik.',
            ],
            [
                'id' => (string) Str::uuid(),
                'name' => 'Programming',
                'description' => 'Kategori ini berisi tutorial coding, tips programming, dan perkembangan dunia software.',
            ],
        ]);

    }
}
