<?php

namespace App\Repositories;

use App\Models\BarangMasuk;

class BarangMasukRepository extends BaseRepository
{
    public function __construct(protected BarangMasuk $barangMasuk)
    {
        $this->model = $this->barangMasuk;
    }

    public function fillable()
    {
        return $this->barangMasuk->getFillable();
    }

    public function rule()
    {
        return [
            'toko_id' => 'required|exists:toko,id',
            'user_id' => 'required|exists:users,id',
            'produks_id' => 'required|exists:produks,id',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'harga_beli' => 'required|integer',
            'satuan_beli_id' => 'required|exists:jenis_satuans,id',
            'jumlah_barang_masuk' => 'required|integer',
            'jumlah_barang_keluar' => 'required|integer',
            'status_id' => 'required|exists:status,id'
        ];
    }
}
