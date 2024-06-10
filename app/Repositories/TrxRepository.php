<?php

namespace App\Repositories;

use App\Models\Transaksi;

class TrxRepository extends BaseRepository
{
    public function __construct(
        public Transaksi $toko,
    ) {
        $this->model = $toko;
    }

    public function fillable()
    {
        return $this->toko->getFillable();
    }

    public function rule()
    {
        return [
            'toko_id' => 'required|exists:toko,id',
            'kasir_id' => 'required|exists:kasir,id',
            'user_id' => 'required|exists:users,id',
            'invoice' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'pelanggan_id' => 'nullable|exists:pelanggans,id',
            'diskon' => 'required|integer|min:0',
            'total_belanja' => 'required|integer|min:0',
            'total_bayar' => 'required|integer|min:0',
            'kembalian' => 'nullable|integer|min:0',
            'payment_type_id' => 'required|exists:payment_types,id',
            'pph' => 'nullable|integer|min:0',
            'status_id' => 'required|exists:status,id',
        ];
    }

    public function getSubTotalDiskon($total, $dison)
    {
        if ($dison != 0)
            return $total * ($dison / 100);
        return 0;
    }

    public function getSubTotalPph($total, $pph)
    {
        if ($pph != 0)
            return $total * ($pph / 100);
        return 0;
    }

    public function withAll()
    {
        return [
            'toko',
            'kasir',
            'user',
            'pelanggan',
            'paymentType',
            'status',
            'troli' => function ($query) {
                return $query->with([
                    'transaksi',
                    'produk',
                    'satuan',
                    'harga' => function ($q) {
                        return $q->with('jenisSatuan');
                    },
                    'kasir',
                    'user',
                    'toko',
                    'status'
                ]);
            },
        ];
    }
}
