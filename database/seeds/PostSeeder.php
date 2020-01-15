<?php

use Illuminate\Database\Seeder;

use App\Models\Post;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        Post::truncate();
        DB::table('sa_post_keyword')->truncate();

        Schema::enableForeignKeyConstraints();
    }
}
