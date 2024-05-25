<?php

namespace App\Http\Controllers;

use App\Services\MasterCollectService;
use Illuminate\Http\Request;
use TaliumAttributes\Collection\Controller\Controllers;
use TaliumAttributes\Collection\Rutes\Get;
use TaliumAttributes\Collection\Rutes\Name;
use TaliumAttributes\Collection\Rutes\Group;
use TaliumAttributes\Collection\Rutes\Post;

#[Controllers()]
#[Group(prefix: 'master', middleware: ['auth'])]
class MasterCollectionController extends Controller
{
    public function __construct(
        public MasterCollectService $masterCollectService
    ) {
    }


    #[Get('get-master/{master}')]
    public function get($master)
    {
        $data = $this->masterCollectService->$master()->getAll();
        return response()->json($data, 200);
    }

    #[Get('get-master/{id}/{master}')]
    public function getId($id, $master)
    {
        $data = $this->masterCollectService->$master()->getId($id);
        return response()->json($data, 200);
    }
}
