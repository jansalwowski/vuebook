<?php

use Illuminate\Database\Seeder;

class CommentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $commentsCount = \App\Models\Post::count() * rand(3, 7);

        factory(\App\Models\Comment::class, $commentsCount)->create();
    }
}
