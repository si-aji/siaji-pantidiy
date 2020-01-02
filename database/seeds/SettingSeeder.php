<?php

use Illuminate\Database\Seeder;

use App\Models\Settings;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Settings::truncate();
        
        $setting = [
            [
                'key' => 'title',
                'value' => 'Social Care',
                'description' => 'Judul dari Website'
            ], [
                'key' => 'description',
                'value' => 'Portal Informasi Seputar Panti Area Yogyakarta',
                'description' => 'Deskripsi dari Website'
            ]
        ];

        foreach($setting as $val){
            Settings::create([
                'setting_name' => ucwords($val['key']),
                'setting_key' => $val['key'],
                'setting_value' => $val['value'],
                'setting_description' => $val['description']
            ]);
        }
    }
}
