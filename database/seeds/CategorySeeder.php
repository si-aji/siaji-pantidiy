<?php

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        Category::truncate();

        Schema::enableForeignKeyConstraints();

        $category = [
            'Aktivitas',
            'Pengumuman',
            'Berita',
            'Pengetahuan',
            'Informasi'
        ];

        foreach($category as $val){
            Category::create([
                'category_title' => $val,
                'category_slug' => str_replace(' ', '-', strtolower($val)),
                'category_description' => null
            ]);
        }
    }
}
