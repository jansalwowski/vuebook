<?php

use App\Events\Posts\UserSubmittedPostToFriendsWall;
use App\Events\Posts\UserSubmittedPostToOwnWall;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class WallTest extends TestCase
{

    use DatabaseMigrations, DatabaseTransactions;


    /** @test */
    public function it_returns_posts_on_main_wall()
    {
        $user = $this->prepareUser();
        $this->be($user);

        $posts = factory(Post::class, 3)->create(['user_id' => $user->id]);

        $responseWall = $posts->toArray();

        $this->json('GET', 'api/wall')
            ->seeJson($responseWall);
    }

    /** @test  */
    public function it_returns_200_ok_when_you_post_to_own_wall()
    {
        $user = $this->prepareUser();
        $this->be($user);

        $requestData = [
            'target_id' => null,
            'content' => 'This is an example test post.'
        ];

        Event::fake();

        $response = $this->call('POST', '/api/posts', $requestData);

        $this->assertEquals(200, $response->status());

        Event::assertFired(UserSubmittedPostToOwnWall::class, function (UserSubmittedPostToOwnWall $e) use ($user) {
            return $e->post->user_id === $user->id;
        });

        Event::assertNotFired(UserSubmittedPostToFriendsWall::class);
    }

    /** @test  */
    public function it_returns_data_of_created_post_when_you_post_to_own_wall()
    {
        $user = $this->prepareUser();
        $this->be($user);

        $requestData = [
            'target_id' => null,
            'content' => 'This is an example test post.',
        ];
        $expectedData = [
            'content' => 'This is an example test post.',
            'target_id' => null,
            'user_id' => $user->id,
        ];

        $this->json('POST', '/api/posts', $requestData)
            ->seeJson($expectedData);
    }

    /** @test  */
    public function it_returns_data_of_created_post_when_you_post_to_friends_wall()
    {
        $user = $this->prepareUser();
        $friend = $this->prepareUser();

        $this->be($user);

        $requestData = [
            'content' => 'This is an example test post.',
            'target_id' => $friend->id,
        ];
        $expectedData = [
            'content' => 'This is an example test post.',
            'target_id' => $friend->id,
            'user_id' => $user->id,
        ];

        $this->json('POST', '/api/posts', $requestData)
            ->seeJson($expectedData);
    }

    private function prepareUser(array $attributes = []) : User
    {
        $user = factory(User::class, 1)->create($attributes);

        return $user;
    }
}
