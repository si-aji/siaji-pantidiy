<?php

use Illuminate\Database\Seeder;

use App\User;
use App\Models\PantiLiputan;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        User::truncate();
        PantiLiputan::truncate();

        Schema::enableForeignKeyConstraints();

        User::create([
            'name' => 'Dwi Aji',
            'email' => 'dwiaji@mail.com',
            'username' => 'dwiaji',
            'password' => bcrypt('dwiaji'),
            'is_active' => true,
            'access' => 'admin'
        ]);
        User::create([
            'name' => 'SIAJI',
            'email' => 'siaji@mail.com',
            'username' => 'siaji',
            'password' => bcrypt('siaji'),
            'is_active' => true,
            'access' => 'admin'
        ]);
        User::create([
            'name' => 'User',
            'email' => 'user@mail.com',
            'username' => 'user',
            'password' => bcrypt('user'),
            'is_active' => true,
            'access' => 'user'
        ]);
    }
}
