<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(SettingSeeder::class);
        $this->call(LocationSettingSeeder::class);
        $this->call(PantiSeeder::class);

        $this->call(PageSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(KeywordSeeder::class);
    }
}
