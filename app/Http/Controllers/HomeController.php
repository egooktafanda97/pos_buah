<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use TaliumAttributes\Collection\Controller\Controllers;
use TaliumAttributes\Collection\Rutes\Get;
use TaliumAttributes\Collection\Rutes\Group;
use TaliumAttributes\Collection\Rutes\Name;
use TaliumAttributes\Collection\Rutes\Post;
use TaliumAttributes\Collection\Rutes\Middleware;

#[Controllers()]
#[Group(prefix: 'home', middleware: ['web'])]
class HomeController extends Controller
{
    #[Get("")]
    public function index()
    {
        return view('Page.Dashboard.index');
    }
    #[Get("testpage")]
    public function testpage()
    {
        return view('Page.TestPage.index');
    }

    #[Get("get/{id}")]
    public function getId($id)
    {
    }

    #[Post("")]
    public function store(Request $request)
    {
    }

    #[Post("{id}")]
    public function update($id)
    {
    }

    #[Post("delete/{id}")]
    public function destory($id)
    {
    }
}
