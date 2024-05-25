<?php

namespace App\Repositories;

use App\Models\StokDetail;

class StokDetailRepository extends BaseRepository
{
    public function __construct(protected StokDetail $stokDetail)
    {
        $this->model = $this->stokDetail;
    }

    public function fillable()
    {
        return $this->stokDetail->getFillable();
    }

    public function rule()
    {
        return [
            'stok_id' => 'required|exists:stoks,id',
            'toko_id' => 'required|exists:toko,id',
            'produks_id' => 'required|exists:produks,id',
            'jumlah' => 'required|integer|min:0',
            'jumlah_sebelumnya' => 'required|integer|min:0',
            'satuan_id' => 'required|exists:jenis_satuans,id',
            'tipe' => 'required|in:masuk,keluar',
        ];
    }
}
