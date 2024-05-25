<?php

namespace App\Services;

use App\Repositories\HargaRepository;

class HargaService
{
    public function __construct(public HargaRepository $hargaRepository)
    {
    }

    public function crete(array $data)
    {
        try {
            return $this->hargaRepository->validate($data)->create();
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }
}
