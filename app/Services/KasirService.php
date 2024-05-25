<?php

namespace App\Services;

use App\Repositories\KasirRepository;
use App\Repositories\TokoRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class KasirService
{
    public function __construct(
        public ActorService $actor,
        public RolePermissionsService $rolePermissionsService,
        public UserRepository $userRepository,
        public TokoRepository $tokoRepository,
        public KasirRepository $kasirRepository
    ) {
    }

    public function create(array $data)
    {
        DB::beginTransaction();
        try {
            $toko = $this->actor->toko();
            if (!$toko) {
                throw new \Exception("Toko not found");
            }
            $data['toko_id'] = $toko->id ?? null;

            $user = $this->userRepository->validate($data)->create();
            $this->rolePermissionsService->setRole($user, ['kasir', "web"]);
            $this->rolePermissionsService->setRole($user, ['kasir-api', "api"]);
            //kasir validation
            $data['user_id'] = $user->id;
            $kasir = $this->kasirRepository->validate($data)->create();
            DB::commit();
            return $kasir;
        } catch (\Throwable $th) {
            DB::rollBack();
            throw new \Exception($th->getMessage());
        }
    }

    public function update($id, array $data)
    {
        DB::beginTransaction();
        try {
            $kasir = $this->kasirRepository->find($id);
            $data['user_id'] = $kasir->user_id;
            $validation = Validator::make($data, $this->kasirRepository->rule());
            if ($validation->fails()) {
                throw new \Exception($validation->errors()->first());
            }
            $kasir = $this->kasirRepository->update($id, $data);
            DB::commit();
            return $kasir;
        } catch (\Throwable $th) {
            DB::rollBack();
            return $th;
        }
    }

    public function delete($id)
    {
        DB::beginTransaction();
        try {
            $kasir = $this->kasirRepository->find($id);
            $kasir = $this->kasirRepository->delete($id);
            DB::commit();
            return $kasir;
        } catch (\Throwable $th) {
            DB::rollBack();
            return $th;
        }
    }

    public function actor()
    {
        return $this->actor->kasir();
    }
}
