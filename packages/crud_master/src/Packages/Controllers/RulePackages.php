<?php

namespace CrudMaster\Packages\Controllers;


use App\Helpers\DatatableTemplating;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use TaliumAttributes\Collection\Controller\Controllers;
use TaliumAttributes\Collection\Rutes\Get;
use TaliumAttributes\Collection\Rutes\Group;
use TaliumAttributes\Collection\Rutes\Post;
use Yajra\DataTables\Facades\DataTables;


trait RulePackages
{

    #[Get("")]
    public function show(Request $request)
    {
        if (request()->ajax()) {
            $data = Role::query();
            return DatatableTemplating::make($data);
        }
        return view('pages.Rules.rules');
    }

    #[Post("")]
    public function store(Request $request)
    {
        try {
            $this->validate($request, [
                'name' => 'required|unique:roles,name',
                'guard_name' => 'nullable',
            ]);

            Role::create(['name' => $request->get('name'), 'guard_name' => "web"]);
            if (!empty($request->api)) {
                Role::create(['name' => $request->get('name') . "-api", 'guard_name' => "api"]);
            }
            return redirect()->route('rules.show');
        } catch (\Throwable $th) {
            return redirect()->route('rules.show')->with('error', $th->getMessage());
        }
    }
}
