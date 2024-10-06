<?php

namespace App\Helper;

use Laravolt\Avatar\Facade as Laravolt;

class Avatar
{
    public static function generateAvatar($fullname)
    {
        return Laravolt::create($fullname)->toBase64();
    }
}
