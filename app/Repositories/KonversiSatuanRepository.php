<?php

namespace App\Repositories;

use App\Models\Konversisatuan;

class KonversiSatuanRepository extends BaseRepository
{
    public function __construct(protected Konversisatuan $konversiSatuan)
    {
        $this->model = $konversiSatuan;
    }

    public function fillable()
    {
        return $this->konversiSatuan->getFillable();
    }

    public function rule()
    {
        return [
            'toko_id' => 'required|exists:toko,id',
            'produks_id' => 'required|exists:produks,id',
            'satuan_id' => 'required|exists:jenis_satuans,id',
            'satuan_konversi_id' => 'required|exists:jenis_satuans,id',
            'nilai_konversi' => 'required|integer',
            'status_id' => 'required|exists:status,id'
        ];
    }
}
