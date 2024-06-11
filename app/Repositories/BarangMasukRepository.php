<?php

namespace App\Repositories;

use App\Models\BarangMasuk;

use function PHPUnit\Framework\returnSelf;

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
        if ($this->getId())
            return $this->nullRule();

        return [
            'kode' => 'required|string', // 'kode' => 'required|string|unique:barang_masuk,kode
            'toko_id' => 'required|exists:toko,id',
            'user_id' => 'required|exists:users,id',
            'produks_id' => 'required|exists:produks,id',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'harga_beli' => 'required|integer',
            'satuan_beli_id' => 'required|exists:jenis_satuans,id',
            'jumlah_selebelumnya' => 'required|integer', // 'jumlah_sebelumnya' => 'required|integer',
            'jumlah_barang_masuk' => 'required|integer',
            'jumlah_barang_keluar' => 'required|integer',
            'status_id' => 'required|exists:status,id'
        ];
    }
    // null rule in validate
    public function nullRule()
    {
        $rules =  [
            'toko_id' => 'nullable|exists:toko,id',
            'user_id' => 'nullable|exists:users,id',
            'produks_id' => 'nullable|exists:produks,id',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'harga_beli' => 'nullable|integer',
            'satuan_beli_id' => 'nullable|exists:jenis_satuans,id',
            'jumlah_barang_masuk' => 'nullable|integer',
            'jumlah_barang_keluar' => 'nullable|integer',
            'status_id' => 'nullable|exists:status,id'
        ];
        //  fillter not null
        return array_filter($rules, function ($value) {
            return !is_null($value);
        });
    }
}
