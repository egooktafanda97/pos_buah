<?php

namespace Captain\module\repository\Users;


interface UserRepositoryInterface
{
    public static function getAllUsers();

    public static function getUserById($UserId);

    public static function deleteUser($UserId);

    public static function createUser(array $UserDetails);

    public static function updateUser($UserId, array $newDetails);

    public static function UserNameCheck(string $username);

    public static function getUserSsoCheck(string $key, string $value);
}
