<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(TestUserSeeder::class);
//         $this->call(UsersSeeder::class);
//         $this->call(PostsSeeder::class);
        $this->call(UsersWithPosts::class);
        $this->call(PostLikesSeeder::class);
        $this->call(FriendsSeeder::class);
        $this->call(CommentsSeeder::class);
        $this->call(CommentLikesSeeder::class);
    }
}
