<?php

namespace App\Repositories;

use App\Models\Kasir;

class KasirRepository extends BaseRepository
{
    public function __construct(
        public Kasir $kasir,
    ) {
        $this->model = $kasir;
    }

    public function fillable()
    {
        return $this->kasir->getFillable();
    }

    public function rule()
    {
        return [
            'user_id' => 'required|exists:users,id',
            'toko_id' => 'required|exists:toko,id',
            'nama' => 'required|string|max:255',
            'alamat' => 'nullable|string|max:255',
            'telepon' => 'nullable|string|max:15',
            'deskripsi' => 'nullable|string|max:1000',
        ];
    }
}
