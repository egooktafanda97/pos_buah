<?php

namespace App\Repositories;

use App\Models\DetailTransaksi;
use App\Models\Transaksi;

class TrxTroliRepository extends BaseRepository
{
    public function __construct(
        public Transaksi $trx,
        public DetailTransaksi $detailTrx
    ) {
        $this->model = $detailTrx;
    }

    public function fillable()
    {
        return $this->detailTrx->getFillable();
    }

    // create and update validation
    public function rule()
    {
        return [
            'toko_id' => 'required|exists:toko,id',
            'kasir_id' => 'required|exists:kasir,id',
            'user_id' => 'required|exists:users,id',
            'invoice' => 'required|string|max:255',
            'transaksi_id' => 'required|exists:transaksi,id',
            'produks_id' => 'required|exists:produks,id',
            'harga_id' => 'required|exists:harga,id',
            'satuan_id' => 'required|exists:jenis_satuans,id',
            'jumlah' => 'required|integer|min:1',
            'total' => 'required|integer|min:0',
            'diskon' => 'required|integer|min:0',
            'status_id' => 'required|exists:status,id',
        ];
    }
}
