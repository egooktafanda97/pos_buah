<?php

namespace Captain\module\services;

use Captain\module\models\Permission;
use Captain\module\models\Role;
use Illuminate\Support\Facades\DB;

class RoleService
{
    public function show($request)
    {
        return [
            "role" => Role::where('guard_name', $request->guard ?? 'web')->whereNotIn("name", ["super-admin"])->orderBy("id", "DESC")->get(),
            "permission" => Permission::whereNotNull("group_permission")
                ->where("guard_name", "web")
                ->when(!empty($request->get("group")), function ($q) use ($request) {
                    $q->where("group_permission", $request->get("group"));
                })
                ->get()
                ->map(function ($x) use ($request) {
                    $roles =  Role::where("id", ($request->get("role-active") ?? null))->first();
                    $x->role_permissions = false;
                    if (!empty($roles) && $roles->hasPermissionTo($x->name))
                        $x->role_permissions = true;
                    return $x;
                }),
            "role_permission" => (Role::where("id", ($request->get("role-active") ?? null))->first()->permissions ?? []),
            "modules" => Permission::select(["group_permission as group"])->groupBy("group_permission")->get()
        ];
    }
    public function store($request)
    {
        try {
            if ($request->guard_api)
                Role::create(["name" => $request->role . "-api", "guard_name" => "api"]);
            Role::create(["name" => $request->role, "guard_name" => "web"]);
            return ["status" => true, "msg" => "Ok", "code" => 201];
        } catch (\Exception $e) {
            return ["status" => false, "msg" => $e->getMessage(), "code" => 403];
        }
    }

    public function store_permission($request)
    {
        try {
            $role = Role::find($request->role);
            $permissions = Permission::whereIn("id", $request->permissionId)->pluck('id', 'id')->all();
            $role->syncPermissions($permissions);
            return ["status" => true, "msg" => "Ok", "code" => 201];
        } catch (\Exception $e) {
            return ["status" => false, "msg" => $e->getMessage(), "code" => 403];
        }
    }

    public  function destory($name)
    {
        try {
            DB::table("roles")->where("name", $name)->delete();
            return ["status" => true, "code" => 201];
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), 500);
        }
    }
}
