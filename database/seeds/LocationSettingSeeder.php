<?php

use Illuminate\Database\Seeder;

use App\Models\Provinsi;
use App\Models\Kabupaten;
use App\Models\Kecamatan;

class LocationSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arr = array(
            // Provinsi
                // Kabupaten
                    // Kecamatan

            'Daerah Istimewa Yogyakarta' => array(
                'Bantul' => array(
                    'Srandakan',
                    'Sanden',
                    'Kretek',
                    'Pundong',
                    'Bambang Lipuro	',
                    'Pandak',
                    'Bantul',
                    'Jetis',
                    'Imogiri',
                    'Dlingo',
                    'Pleret',
                    'Piyungan',
                    'Banguntapan',
                    'Sewon',
                    'Kasihan',
                    'Pajangan',
                    'Sedayu',
                ),
                'Gunung Kidul' => array(
                    'Panggang',
                    'Purwosari',
                    'Paliyan',
                    'Sapto Sari',
                    'Kecamatan Tepus',
                    'Tanjungsari',
                    'Rongkop',
                    'Girisubo',
                    'Semanu',
                    'Ponjong',
                    'Karangmojo',
                    'Wonosari',
                    'Playen',
                    'Patuk',
                    'Gedang Sari',
                    'Nglipar',
                    'Ngawen',
                    'Semin',
                ),
                'Kulon Progo' => array(
                    'Temon',
                    'Wates',
                    'Panjatan',
                    'Lendah',
                    'Sentolo',
                    'Pengasih',
                    'Kokap',
                    'Girimulyo',
                    'Nanggulan',
                    'Kalibawang',
                    'Samigaluh',
                ),
                'Sleman' => array(
                    'Moyudan',
                    'Minggir',
                    'Sayegan',
                    'Godean',
                    'Gamping',
                    'Mlati',
                    'Depok',
                    'Berbah',
                    'Prambanan',
                    'Kalasan',
                    'Ngemplak',
                    'Ngaglik',
                    'Sleman',
                    'Tempel',
                    'Turi',
                    'Pakem',
                    'Cangkringan',
                ),
                'Kota Yogyakarta' => array(
                    'Mantrijeron',
                    'Kraton',
                    'Mergangsan',
                    'Umbulharjo',
                    'Kotagede',
                    'Gondokusuman',
                    'Danurejan',
                    'Pakualaman',
                    'Gondomanan',
                    'Ngampilan',
                    'Wirobrajan',
                    'Gedong Tengen',
                    'Jetis',
                    'Tegalrejo',
                )
            ),
        );

        foreach($arr as $key => $value){
            // Check if provinsi is array
            if(is_array($value)){
                $province = Provinsi::where('provinsi_name', $key)->first();
                if(empty($province)){
                    // Create Provinsi if not exists
                    $province = Provinsi::create([
                        'provinsi_name' => $key
                    ]);
                }
                
                foreach($value as $prokey => $proval){
                    // Check if Kabupaten is array
                    if(is_array($proval)){
                        $district = Kabupaten::where('provinsi_id', $province->id)->where('kabupaten_name', $prokey)->first();
                        if(empty($district)){
                            // Create Kabupaten if not exists
                            $district = Kabupaten::create([
                                'provinsi_id' => $province->id,
                                'kabupaten_name' => $prokey
                            ]);
                        }
                        
                        foreach($proval as $keckey => $kecval){
                            $subdistrict = Kecamatan::where('kabupaten_id', $district->id)->where('kecamatan_name', $kecval)->first();
                            if(empty($subdistrict)){
                                // Create Kecamatan if not exists
                                $subdistrict = Kecamatan::create([
                                    'kabupaten_id' => $district->id,
                                    'kecamatan_name' => $kecval
                                ]);
                            }
                        }
                    } else {
                        $district = Kabupaten::where('provinsi_id', $province->id)->where('kabupaten_name', $prokey)->first();
                        if(empty($district)){
                            // Create Kabupaten if not exists
                            $district = Kabupaten::create([
                                'provinsi_id' => $province->id,
                                'kabupaten_name' => $proval
                            ]);
                        }
                    }
                }
            } else {
                $province = Provinsi::where('provinsi_name', $value)->first();
                if(empty($province)){
                    // Create Provinsi if not exists
                    $province = Provinsi::create([
                        'provinsi_name' => $value
                    ]);
                }
            }
        }
    }
}
