<?php

use Illuminate\Database\Seeder;

use App\Models\Panti;
use App\Models\PantiLiputan;
use App\Models\Provinsi;
use App\Models\Kabupaten;
use App\Models\Kecamatan;

use Faker\Factory as Faker;
use Illuminate\Support\Facades\Schema;

class PantiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        PantiLiputan::truncate();
        Panti::truncate();
        Schema::enableForeignKeyConstraints();

        for($i = 0; $i < 500; $i++){
            $provinsi = Provinsi::inRandomOrder()->first();
            $kabupaten = Kabupaten::where('provinsi_id', $provinsi->id)->inRandomOrder()->first();
            $kecamatan = Kecamatan::where('kabupaten_id', $kabupaten->id)->inRandomOrder()->first();

            $faker = Faker::create('id_ID');
            $name = $faker->unique()->company;

            $panti = Panti::where('panti_slug', strtolower(str_replace(' ', '-', $name)))->first();
            if(empty($panti)){
                Panti::create([
                    'provinsi_id' => $provinsi->id,
                    'kabupaten_id' => $kabupaten->id,
                    'kecamatan_id' => $kecamatan->id,
                    'panti_name' => $name,
                    'panti_slug' => strtolower(str_replace(' ', '-', $name)),
                    'panti_alamat' => $faker->address,
                    'panti_description' => $provinsi->id,
                ]);
            }
        }
    }
}
