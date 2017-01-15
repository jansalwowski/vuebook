<?php

use Illuminate\Database\Seeder;

class FriendsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = \App\Models\User::all();

        $userIds = $users->pluck('id');

        foreach ($users as $user) {
            $randomFollowing = $userIds->reject(function ($value, $key) use ($user) {
                return $value === $user->id;
            });

            $max = $randomFollowing->count();
            $amount = random_int(2, $max / 2);
            $randomFollowing = $randomFollowing->random($amount);

            $user->following()->sync($randomFollowing);
        }
    }
}
