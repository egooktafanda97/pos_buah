<?php

namespace App\Repositories;

use App\Models\Stok;

class StokRepository extends BaseRepository
{
    public function __construct(protected Stok $stok)
    {
        $this->model = $this->stok;
    }

    public function fillable()
    {
        return $this->stok->getFillable();
    }

    public function rule()
    {
        return [
            'toko_id' => 'required|exists:toko,id',
            'produks_id' => 'required|exists:produks,id',
            'jumlah' => 'required|integer',
            'jumlah_sebelumnya' => 'required|integer',
            'satuan_id' => 'required|exists:jenis_satuans,id',
            'keterangan' => 'nullable|string'
        ];
    }
}
