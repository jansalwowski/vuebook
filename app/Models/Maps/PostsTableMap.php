<?php
//@formatter:off
declare(strict_types = 1);
//@formatter:on


namespace App\Models\Maps;


class PostsTableMap
{
    const TYPE_MOVIE = 'movie';
    const TYPE_PHOTO = 'photo';
    const TYPE_SHARE = 'share';
    const TYPE_TEXT  = 'text';

    const AVAILABLE_TYPES = [
        self::TYPE_MOVIE,
        self::TYPE_PHOTO,
        self::TYPE_SHARE,
        self::TYPE_TEXT,
    ];

    const PRIVACY_PUBLIC = 'public';
    const PRIVACY_FRIENDS = 'friends';
    const PRIVACY_PRIVATE = 'private';

    const AVAILABLE_PRIVACY_TYPES = [
        self::PRIVACY_FRIENDS,
        self::PRIVACY_PUBLIC,
        self::PRIVACY_PRIVATE,
    ];
}