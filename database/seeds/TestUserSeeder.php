<?php

use Illuminate\Database\Seeder;

class TestUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new \App\Models\User();

        $user->name = 'Jan Salwowski';
        $user->password = bcrypt('janek123');
        $user->birthday = \Carbon\Carbon::createFromDate(1994, 10, 27);
        $user->email = 'jan.salwowski@o2.pl';

        $user->save();

        factory(\App\Models\Post::class, 20)->create(['user_id' => $user->id]);
    }
}
