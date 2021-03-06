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
        factory(\App\User::class, 10)->create();
        factory(\App\Category::class, 5)->create();
        factory(\App\Question::class, 20)->create();
        factory(\App\Reply::class, 30)->create();
        factory(\App\Like::class, 50)->create();
    }
}
