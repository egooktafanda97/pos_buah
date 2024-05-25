<?php

namespace App\Services;

use App\Repositories\KonversiSatuanRepository;

class KonversiSatuanService
{
    public function __construct(
        public KonversiSatuanRepository $konversiSatuanRepository
    ) {
    }

    public function create(array $data)
    {
        try {
            return $this->konversiSatuanRepository->validate($data)->create();
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }
}
