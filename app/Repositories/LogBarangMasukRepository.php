<?php

namespace App\Repositories;

use App\Models\LogBarangMasuk;
use App\Services\ConstSatuanTerkecil;

class LogBarangMasukRepository extends BaseRepository
{

    public function __construct(protected LogBarangMasuk $logBarangMasuk)
    {
        $this->model = $this->logBarangMasuk;
    }

    public function fillable()
    {
        return $this->logBarangMasuk->getFillable();
    }

    public function rule()
    {
        return [
            'kode' => 'required|string', // 'kode' => 'required|string|unique:barang_masuk,kode
            'toko_id' => 'required|exists:toko,id',
            'user_id' => 'required|exists:users,id',
            'produks_id' => 'required|exists:produks,id',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'harga_beli' => 'required|integer|min:0',
            'satuan_beli_id' => 'required|exists:jenis_satuans,id',
            'jumlah_selebelumnya' => 'required|integer', // 'jumlah_sebelumnya' => 'required|integer',
            'jumlah_barang_masuk' => 'required|integer',
            'jumlah_barang_keluar' => 'required|integer|min:0',
            'stok_sisa' => 'required|integer|min:0',
            'satuan_stok_id' => 'required|exists:jenis_satuans,id',
            'status_id' => 'required|exists:status,id',
        ];
    }
}
