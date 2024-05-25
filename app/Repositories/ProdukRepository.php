<?php

namespace App\Repositories;

use App\Models\Produk;

class ProdukRepository extends BaseRepository
{
    public function __construct(protected Produk $produks)
    {
        $this->model = $this->produks;
    }
    public function fillable()
    {
        return $this->produks->getFillable();
    }

    public function rule()
    {
        return [
            'toko_id' => 'required|exists:toko,id',
            'user_id' => 'required|exists:users,id',
            'nama_produk' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|string|max:255',
            'jenis_produk_id' => 'required|exists:jenis_produks,id',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'barcode' => 'nullable|string|max:100',
            'rak_id' => 'nullable|exists:rak,id',
            'satuan_jual_terkecil_id' => 'required|integer',
            'status_id' => 'required|exists:status,id',
        ];
    }

    public function findWhereWith($where, $with = [])
    {
        return $this->model->where(function ($q) use (&$where) {
            return $where($q);
        })->with($with)->first();
    }

    public function getPrieces($id, $unit, $qty, $load = [])
    {

        $prod = $this
            ->findWhereWith(where: function ($query) use ($id) {
                return  $query->where('id', $id);
            }, with: [
                'harga' => function ($harga) {
                    return $harga->with('jenisSatuan');
                },
                'toko',
                'jenisProduk',
                'supplier',
                'rak',
                'status',
                'stok'
            ]);
        $satuan = !empty($unit) ? $unit : $prod->satuan_jual_terkecil_id;
        $hargas = $prod->harga->where('jenis_satuan_id', $satuan)->first();
        $prod->qty = $qty;
        $prod->satuan_beli = $satuan;
        $prod->harga_id = $hargas->id;
        $prod->harga_final = $hargas->harga;
        $prod->total = $prod->qty * $prod->harga->where('jenis_satuan_id', $satuan)->first()->harga;
        $prod->stokBefore = $prod->stok->jumlah;
        $prod->stokAfter = (int) $prod->stok->jumlah - (int) $prod['qty'];
        // Mengubah prod menjadi array
        if (!empty($load)) {
            $prodArray = $prod->toArray();
            $prodArray = array_intersect_key($prodArray, array_flip($load));
            return $prodArray;
        }
        return $prod;
    }
}
