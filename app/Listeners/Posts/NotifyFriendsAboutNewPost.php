<?php

namespace App\Listeners\Posts;

use App\Events\Posts\UserSubmittedPostToOwnWall;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyFriendsAboutNewPost
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UserSubmittedPostToOwnWall  $event
     * @return void
     */
    public function handle(UserSubmittedPostToOwnWall $event)
    {
        //
    }
}
