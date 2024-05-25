<?php

namespace App\Repositories;

use App\Models\Harga;

class HargaRepository extends BaseRepository
{
    public function __construct(public Harga $harga)
    {
        $this->model = $this->harga;
    }
    public function fillable()
    {
        return [
            'user_id',
            'toko_id',
            'produks_id',
            'harga',
            'jenis_satuan_id',
            'user_update_id'
        ];
    }
    public function rule()
    {
        return [
            'user_id' => 'required|exists:users,id',
            'toko_id' => 'required|exists:toko,id',
            'produks_id' => 'required|exists:produks,id',
            'harga' => 'required|integer|min:0',
            'jenis_satuan_id' => 'required|exists:jenis_satuans,id',
            'user_update_id' => 'nullable|exists:users,id',
        ];
    }
}
