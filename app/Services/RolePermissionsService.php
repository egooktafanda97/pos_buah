<?php

namespace App\Services;

use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionsService
{

    public function __construct(
        public ActorService $actor,
    ) {
    }

    public function create(string $name)
    {
        return Role::create(['name' => $name]);
    }

    public function createPermissions(string $name)
    {
        return Permission::create(['name' => $name]);
    }

    public function setRulePermissions($roleName, $permissionName)
    {
        $role = Role::findByName($roleName);
        $permission = Permission::findByName($permissionName);
        $role->givePermissionTo($permission);
        return $role;
    }

    public function setRulePermissionsArray($roleName, $permissionName)
    {
        $role = Role::findByName($roleName);
        $permission = Permission::findByName($permissionName);
        $role->givePermissionTo($permission);
        return $role;
    }

    public function setUserRole($user, $roleName)
    {
        $user = User::find($user);
        $user->assignRole($roleName);
        return $user;
    }

    public function newRole($name, $guard_name)
    {
        $response = Role::firstOrCreate(['guard_name' => $guard_name, 'name' => $name]);
        return $response;
    }

    public function createRole($models, $role)
    {
        $models->assignRole($role);
    }

    public function setRole($users, array $role)
    {
        if (!$roler = $this->newRole($role[0], ($role[1] ?? 'web')))
            return ["error" => "role  could not be created"];
        $this->createRole($users, $roler);
    }
}
