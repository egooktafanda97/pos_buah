<?php

namespace TaliumAttributes\helper;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

trait FileHelpers
{
    public static function app_path($app = '')
    {
        return app_path($app);
    }

    public function base_path($path)
    {
        return base_path($path);
    }
}
