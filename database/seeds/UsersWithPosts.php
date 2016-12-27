<?php

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class UsersWithPosts extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = new Faker\Generator();
        $faker->addProvider(new Faker\Provider\Internet($faker));

        factory(User::class, 20)
            ->create()
            ->each(function (User $user) use ($faker) {
                $count = $faker->randomDigit;

                if ($count === 0)
                {
                    return;
                }

                if ($count === 1)
                {
                    /** @var Post $post */
                    $post = factory(Post::class)->make(['user_id' => $user->id]);

                    $user->posts()->save($post);

                    return;
                }

                /** @var \Illuminate\Database\Eloquent\Collection $posts */
                $posts = factory(Post::class, $count)->make(['user_id' => $user->id]);

                $user->posts()->saveMany($posts);
            });
    }
}
