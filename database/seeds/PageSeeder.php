<?php

use Illuminate\Database\Seeder;
use App\Models\Page;
use Faker\Factory as Faker;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Page::truncate();

        for($i = 0; $i < 50; $i++){
            $faker = Faker::create('id_ID');

            $aval_status = [true, false];
            $status = $aval_status[array_rand($aval_status)];
            $slug = $faker->slug;
            Page::create([
                'page_title' => ucwords(str_replace('-', ' ', $slug)),
                'page_slug' => $slug,
                'page_thumbnail' => null,
                'page_content' => $faker->randomHtml(2,3),
                'page_shareable' => $status,
                'page_status' => $status ? 'published' : 'draft',
                'page_published' => $status == true ? date('Y-m-d H:i:s') : null
            ]);
        }
    }
}
