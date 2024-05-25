<?php

namespace App\Services;

use App\Dtos\ContainerDTos;
use App\Models\JenisSatuan;
use App\Repositories\BarangMasukRepository;
use App\Repositories\KonversiSatuanRepository;
use App\Repositories\LogBarangMasukRepository;
use App\Repositories\ProdukRepository;
use App\Repositories\StokDetailRepository;
use App\Repositories\StokRepository;
use App\Repositories\TokoRepository;

class BarangMasukService
{
    public $produk;
    public $toko;
    public $suplier;
    public $jenisSatuan;
    public $harga_beli;
    public $jumlah_barang_masuk;
    public $stokFinal;

    public function __construct(
        public ActorService $actorService,
        public BarangMasukRepository $barangMasukRepository,
        public LogBarangMasukRepository $logBarangMasukRepository,
        public KonversiSatuanRepository $konversiSatuanRepository,
        public TokoRepository $tokoRepository,
        public ProdukRepository $produkRepository,
        public StokRepository $stokRepository,
        public JenisSatuan $jenisSatuanModel,
        public ContainerDTos $contrainerDTos,
        public StokDetailRepository $stokDetail
    ) {
    }

    public function initialize(array $data)
    {
        $this->produk = $this->produkRepository->find($data['produks_id']);
        $this->toko = $this->actorService->toko(tokoId: $data['toko_id']);
        $this->suplier = $this->actorService->supplier($data['supplier_id']);
        $this->jenisSatuan = $this->jenisSatuanModel->find($data['satuan_beli_id']);
        $this->harga_beli = $data['jumlah_barang_masuk'];
        $this->jumlah_barang_masuk = $data['harga_beli'];
        $this->stokFinal =  $this->stokRepository->findWhere(function ($stoks) {
            return $stoks->where("produks_id", $this->produk->id);
        });
        return $this;
    }



    public function store(array $data = [])
    {
        try {
            if (count($data) > 0)
                $this->initialize($data);

            $this->barangMasukRepository->validate([
                'toko_id' => $this->toko->id,
                'user_id' =>  $this->actorService->authId(),
                'produks_id' => $this->produk->id,
                'supplier_id' => $this->suplier->id,
                'harga_beli' => $this->harga_beli, // harnga satuan
                'satuan_beli_id' => $this->jenisSatuan->id,
                'jumlah_barang_masuk' => $this->jumlah_barang_masuk,
                'jumlah_barang_keluar' => 0,
                'status_id' => StatusService::final
            ])->create();
            $this->log();
            $this->updateStok();
            $this->stokDetail();

            return $this;
        } catch (\Throwable $th) {
            throw new \Exception('barang maasuk: ' . $th->getMessage(), 1);
        }
    }

    public function log()
    {

        try {
            $satuanTerkecilBarang = $this->jenisSatuanModel->find($this->produkRepository->find($this->produk->id)->satuan_jual_terkecil_id);
            $this->logBarangMasukRepository->validate([
                'toko_id' => $this->toko->id,
                'user_id' =>  $this->actorService->authId(),
                'produks_id' => $this->produk->id,
                'supplier_id' => $this->suplier->id,
                'harga_beli' => $this->harga_beli, // harnga satuan
                'satuan_beli_id' => $this->jenisSatuan->id,
                'jumlah_barang_masuk' => $this->jumlah_barang_masuk,
                'jumlah_barang_keluar' => 0,
                'stok_sisa' =>  0, // stok sebelum nya
                'satuan_stok_id' => $satuanTerkecilBarang->id,
                'status_id' => 1
            ])->create();
            return $this;
        } catch (\Throwable $th) {
            throw new \Exception('log : ' . $th->getMessage(), 1);
        }
    }

    public function updateStok()
    {
        try {
            $stoks = $this->stokRepository->model->where("produks_id", $this->produk->id)->first();
            $this->stokRepository->validate([
                'toko_id' => $this->toko->id,
                'produks_id' => $this->produk->id,
                'jumlah' => (!empty($this->stokFinal) ? $this->stokFinal->jumlah : 0) + $this->jumlah_barang_masuk,
                'jumlah_sebelumnya' => (!empty($this->stokFinal) ? $this->stokFinal->jumlah : 0),
                'satuan_id' => $this->jenisSatuan->id,
                'keterangan' => 'barang masuk',
                'status_id' => StatusService::final
            ])->createOrUpdate((empty($stoks) ? null : [
                "id" => $stoks->id,
                "data" => [
                    'jumlah' => (!empty($this->stokFinal) ? $this->stokFinal->jumlah : 0) + $this->jumlah_barang_masuk,
                    'jumlah_sebelumnya' => (!empty($this->stokFinal) ? $this->stokFinal->jumlah : 0),
                ]
            ]));
            return  $this;
        } catch (\Throwable $th) {
            throw new \Exception('stok: ' . $th->getMessage());
        }
    }

    public function stokDetail()
    {
        try {
            $stoks = $this->stokRepository->model->where("produks_id", $this->produk->id)->first();
            $this->stokDetail->validate([
                'stok_id' => $stoks->id,
                'toko_id' => $this->toko->id,
                'produks_id' => $this->produk->id,
                'jumlah' => (!empty($this->stokFinal) ? $this->stokFinal->jumlah : 0) + $this->jumlah_barang_masuk,
                'jumlah_sebelumnya' => (!empty($this->stokFinal) ? $this->stokFinal->jumlah : 0),
                'satuan_id' => $this->jenisSatuan->id,
                'tipe' => 'masuk'
            ])->create();
            return  $this;
        } catch (\Throwable $th) {
            throw new \Exception('stok: ' . $th->getMessage());
        }
    }
}
