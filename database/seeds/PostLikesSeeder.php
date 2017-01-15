<?php

use Illuminate\Database\Seeder;

class PostLikesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $postIds = \App\Models\Post::pluck('id');

        $userIds = \App\Models\User::pluck('id');

        $likes = collect();

        foreach ($userIds as $userId) {
            $userLikes = $postIds->random(rand(2, 40))->map(function ($postId) use ($userId) {
                return [
                    'likeable_id' => $postId,
                    'likeable_type' => 1,
                    'user_id' => $userId,
                    'created_at' => \Carbon\Carbon::now(),
                ];
            });

            $likes = $likes->merge($userLikes);
        }

        foreach ($likes->chunk(100) as $likeChunk) {
            \App\Models\Like::insert($likeChunk->toArray());
        }
    }
}
