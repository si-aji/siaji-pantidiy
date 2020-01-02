<?php

use Illuminate\Database\Seeder;
use App\Models\Keyword;

class KeywordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        Keyword::truncate();

        Schema::enableForeignKeyConstraints();

        $keyword = [
            'aktivitas panti',
            'social care',
            'peduli',
            'bantuan',
            'donasi',
            'anak yatim',
            'yatim',
            'kemanusiaan',
            'pahala',
            'amalan',
            'rezeki',
            'berbagi'
        ];

        foreach($keyword as $val){
            Keyword::create([
                'keyword_title' => $val,
                'keyword_slug' => str_replace(' ', '-', strtolower($val)),
            ]);
        }
    }
}
