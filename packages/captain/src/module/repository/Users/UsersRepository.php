<?php

namespace Captain\module\repository\Users;

use App\Models\User;

class UsersRepository implements UserRepositoryInterface
{
    public static function getAllUsers()
    {
        return User::all();
    }

    public static function getUserById($UserId)
    {
        return User::findOrFail($UserId);
    }

    public static function deleteUser($UserId)
    {
        User::destroy($UserId);
    }

    public static function createUser(array $UserDetails)
    {
        return User::create($UserDetails);
    }

    public static function updateUser($UserId, array $newDetails)
    {
        return User::whereId($UserId)->update($newDetails);
    }

    public static function UserNameCheck(string $username)
    {
        $users = User::where("username", $username)->first();
        if (!$users)
            return null;
        return $users;
    }
    public static function getUserSsoCheck($key, $value)
    {
        $users = User::where($key, $value)->first();
        if (!$users)
            return null;
        return $users;
    }
}
