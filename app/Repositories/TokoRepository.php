<?php

namespace App\Repositories;

use App\Models\Toko;

class TokoRepository extends BaseRepository
{
    public function __construct(
        public Toko $toko,
    ) {
        $this->model = $toko;
    }

    public function fillable()
    {
        return $this->toko->getFillable();
    }

    // create and update validation
    public function rule()
    {
        return [
            'user_id' => 'required|exists:users,id',
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'telepon' => 'required|string|max:15',
            'logo' => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string|max:1000',
        ];
    }
}
