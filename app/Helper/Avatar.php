<?php

namespace App\Helper;

use Laravolt\Avatar\Facade as Laravolt;

class Avatar
{
    public static function generateAvatar($username)
    {
        return Laravolt::create($username)->toBase64();
    }
}
