<?php

namespace App\Services;

use App\Repositories\TokoRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TokoService
{
    public function __construct(
        public ActorService $actor,
        public RolePermissionsService $rolePermissionsService,
        public UserRepository $userRepository,
        public TokoRepository $tokoRepository
    ) {
    }

    public function create(array $data)
    {
        DB::beginTransaction();
        try {
            //user validation
            $user = $this->userRepository->validate($data)->create();
            if ($user instanceof \Throwable) {
                throw new \Exception($user->getMessage());
            }
            $this->rolePermissionsService->setRole($user, ['toko', "web"]);
            $this->rolePermissionsService->setRole($user, ['toko-api', "api"]);
            //toko validation
            $data['user_id'] = $user->id;
            $toko = $this->tokoRepository->validate($data)->create();
            if ($toko instanceof \Throwable) {
                throw new \Exception($user->getMessage());
            }
            DB::commit();
            return $toko;
        } catch (\Throwable $th) {
            DB::rollBack();
            throw new \Exception($th->getMessage());
        }
    }
    //update
    public function update($id, array $data)
    {
        DB::beginTransaction();
        try {
            $toko = $this->tokoRepository->find($id);
            $data['user_id'] = $toko->user_id;
            $validation = Validator::make($data, $this->tokoRepository->rule());
            if ($validation->fails()) {
                throw new \Exception($validation->errors()->first());
            }
            $toko = $this->tokoRepository->update($id, $data);
            DB::commit();
            return $toko;
        } catch (\Throwable $th) {
            DB::rollBack();
            return $th;
        }
    }

    //detete
    public function delete($id)
    {
        DB::beginTransaction();
        try {
            $toko = $this->tokoRepository->find($id);
            $toko = $this->tokoRepository->delete($id);
            $user = $this->userRepository->delete($toko->user_id);
            DB::commit();
            return $toko;
        } catch (\Throwable $th) {
            DB::rollBack();
            return $th;
        }
    }
    public function actor()
    {
        return $this->actor->toko();
    }
}
