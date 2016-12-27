<?php
/**
 * Created by PhpStorm.
 * User: jansalwowski
 * Date: 25.12.2016
 * Time: 14:05
 */

namespace App\Contracts;


use App\Models\User;

interface Commentable
{
    public function comments();

    public function comment(string $message, User $user = null);

    public function hasComments();
}