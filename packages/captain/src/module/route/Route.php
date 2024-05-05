<?php

namespace Captain\module\route;

use Illuminate\Support\Facades\Route as Routes;

class Route
{
    public function web(): void
    {
        Routes::get('/captain', function () {

        });
    }

}
