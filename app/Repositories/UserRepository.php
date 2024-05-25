<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserRepository extends BaseRepository
{
    public function __construct(
        public User $user,
    ) {
        $this->model = $user;
    }

    public function fillable()
    {
        return $this->user->getFillable();
    }
    public function rule()
    {
        return [
            'nama' => 'required',
            'username' => 'required|unique:users,username',
            'password' => 'required',
        ];
    }
}
