<?php

use Illuminate\Database\Seeder;

class CommentLikesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $commentIds = \App\Models\Comment::pluck('id');

        $userIds = \App\Models\User::pluck('id');

        $likes = collect();

        foreach ($userIds as $userId) {
            $userLikes = $commentIds->random(rand(2, 40))->map(function ($commentId) use ($userId) {
                return [
                    'likeable_id' => $commentId,
                    'likeable_type' => 2,
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
