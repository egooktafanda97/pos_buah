<?php

namespace App\Repositories;

use App\Models\Rak;

class RakRepository extends BaseRepository
{
    public function __construct(protected Rak $rak)
    {
    }
    public function fillable()
    {
        return $this->rak->getFillable();
    }

    public function rule()
    {
        return [
            'toko_id' => 'required|exists:toko,id',
            'nomor' => 'required|integer',
            'nama' => 'required|string|max:255',
            'kapasitas' => 'required|integer',
        ];
    }
}
