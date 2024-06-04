<?php

namespace App\Http\Controllers;

use TaliumAttributes\Collection\Controller\Controllers;
use TaliumAttributes\Collection\Rutes\Get;
use TaliumAttributes\Collection\Rutes\Group;
use TaliumAttributes\Collection\Rutes\Name;

#[Controllers()]
#[Group(prefix: 'burung', middleware: [])]
#[Name("burung")]
class BurungControlelr extends Controller
{
    #[Get(["index", "show"])]
    public function index()
    {
    }
}
