<?php
/**
 * Created by PhpStorm.
 * User: jansalwowski
 * Date: 25.12.2016
 * Time: 12:56
 */

namespace App\Contracts;


use App\Models\User;

interface Likeable
{

    public function like(User $user = null);

    public function unlike(User $user = null);

    public function hasLikes();

    public function isLikedBy(User $user);

    public function likes();

}