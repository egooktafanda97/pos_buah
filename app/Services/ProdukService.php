<?php

namespace App\Services;

use App\Models\Produk;
use App\Repositories\ProdukRepository;
use Illuminate\Http\Request;

class ProdukService
{
    public function __construct(public ProdukRepository $produkRepository)
    {
    }

    public function create(array $data): Produk
    {
        try {
            return $this->produkRepository->validate($data)->create();
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }

    // data penjualan produk detail
    public function getSellDetail(array | Request $data)
    {
        return $this->produkRepository->getPrieces(
            id: $data->id ?? $data['id'],
            unit: $data->satuan ?? $data['satuan'],
            qty: $data->qty ?? $data['qty'],
        );
    }

    public function searchProduk(string | int $search)
    {
        return $this->produkRepository->model->where(function ($q) use ($search) {
            return $q->where('nama_produk', 'like', "%$search%")
                ->orWhere('barcode', 'like', "%$search%")
                ->orWhere('id', $search);
        })
            ->with('harga', function ($h) {
                return $h->with('jenisSatuan');
            })
            ->take(5)->get()->map(function ($prod) {
                return $prod;
            });
    }

    public function getPriece(array | Request $data)
    {
        return $this->produkRepository->getPrieces(
            id: $data->id ?? $data['id'],
            unit: $data->satuan ?? $data['satuan'],
            qty: $data->qty ?? $data['qty'],
            load: [
                'nama_produk', 'barcode', 'qty', 'harga', 'harga_final',
                'satuan_beli',
                'total',
                'stokBefore',
                'stokAfter',
            ]
        );
    }

    public function getProdukById($id)
    {
        return $this->produkRepository->find($id);
    }
}
