<?php

namespace App\Services;

use App\Dtos\ContainerDTos;
use App\Models\JenisSatuan;
use App\Models\LogBarangMasuk;
use App\Repositories\BarangMasukRepository;
use App\Repositories\KonversiSatuanRepository;
use App\Repositories\LogBarangMasukRepository;
use App\Repositories\ProdukRepository;
use App\Repositories\StokDetailRepository;
use App\Repositories\StokRepository;
use App\Repositories\TokoRepository;
use Illuminate\Support\Str;

class BarangMasukService
{
    public $produk;
    public $toko;
    public $suplier;
    public $jenisSatuan;
    public $harga_beli;
    public $jumlah_sebelumnya;
    public $jumlah_barang_masuk;
    public $jumlah;
    public $stokFinal;
    public $updateId;
    public $kode;
    public $barangMasukKonversiStok;
    public $data;

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
        $this->data = $data;
        $this->kode = Str::random(10);
        $this->produk = $this->produkRepository->find($data['produks_id']);
        $this->toko = !empty($data['toko_id']) ? $this->actorService->toko(tokoId: $data['toko_id']) : $this->actorService->toko();
        $this->suplier = $this->actorService->supplier($data['supplier_id']);
        $this->jenisSatuan = $this->jenisSatuanModel->find($data['satuan_beli_id']);
        $this->harga_beli = $data['harga_beli'];
        $this->jumlah_sebelumnya = $this->stokRepository->findWhere(function ($query) {
            return $query->where("produks_id", $this->produk->id);
        })->jumlah ?? 0;
        $this->jumlah_barang_masuk = $data['jumlah_barang_masuk'];
        $this->stokFinal =  $this->stokRepository->findWhere(function ($stoks) {
            return $stoks->where("produks_id", $this->produk->id);
        });
        $this->updateId = $data['id'] ?? null;
        $this->barangMasukKonversiStok = KonversiSatuanService::konversi($this->produk->id, $this->jenisSatuan->id, $data['jumlah_barang_masuk']);
        return $this;
    }



    public function store(array $data = [])
    {
        try {
            if (count($data) > 0)
                $this->initialize($data);

            $bar = $this->barangMasukRepository->validate([
                'kode' => $this->kode,
                'toko_id' => $this->toko->id,
                'user_id' =>  $this->actorService->authId(),
                'produks_id' => $this->produk->id,
                'supplier_id' => $this->suplier->id,
                'harga_beli' => $this->harga_beli, // harnga satuan
                'satuan_beli_id' => $this->jenisSatuan->id,
                'jumlah_selebelumnya' => $this->jumlah_sebelumnya,
                'jumlah_barang_masuk' => $this->jumlah_barang_masuk,
                'jumlah_barang_keluar' => 0,
                'status_id' => StatusService::final
            ]);
            if ($this->barangMasukRepository->findWhere(function ($query) {
                return $query->where("produks_id", $this->produk->id);
            })) {
                $bar->updateWhere(function ($query) {
                    return $query->where("produks_id", $this->produk->id);
                });
            } else {
                $bar->create();
            }
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
                'kode' => $this->kode,
                'toko_id' => $this->toko->id,
                'user_id' =>  $this->actorService->authId(),
                'produks_id' => $this->produk->id,
                'supplier_id' => $this->suplier->id,
                'harga_beli' => $this->harga_beli, // harnga satuan
                'satuan_beli_id' => $this->jenisSatuan->id,
                'jumlah_selebelumnya' => $this->jumlah_sebelumnya,
                'jumlah_barang_masuk' => $this->jumlah_barang_masuk,
                'jumlah_barang_keluar' => 0,
                "stok_sisa" => $this->jumlah_sebelumnya,
                'satuan_stok_id' => $satuanTerkecilBarang->id,
                'status_id' => StatusService::final,
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
                'jumlah_sebelumnya' =>  $this->jumlah_sebelumnya,
                'jumlah' =>  $this->jumlah_sebelumnya + $this->barangMasukKonversiStok,
                'satuan_id' =>  $this->produk->satuan_jual_terkecil_id,
                'keterangan' => 'barang masuk',
                'status_id' => StatusService::final
            ])->createOrUpdate((empty($stoks) ? null : [
                "id" => $stoks->id,
                "data" => [
                    'jumlah' => $this->jumlah_sebelumnya + $this->barangMasukKonversiStok,
                    'jumlah_sebelumnya' =>  $this->jumlah_sebelumnya,
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
                'jumlah_sebelumnya' =>  $this->jumlah_sebelumnya,
                'jumlah' =>  $this->jumlah_sebelumnya + $this->barangMasukKonversiStok,
                'satuan_id' =>  $this->produk->satuan_jual_terkecil_id,
                'tipe' => 'masuk'
            ])->create();
            return  $this;
        } catch (\Throwable $th) {
            throw new \Exception('stok: ' . $th->getMessage());
        }
    }

    // update barang masuk

    public function update(array $data = [])
    {
        return $this->logProccessUpdate();
    }
    public function logProccessUpdate()
    {
        $log = $this->logBarangMasukRepository->find($this->data['id']);
        $prod = $this->produkRepository->find($log->produks_id);
        try {
            $previousLog = LogBarangMasuk::whereProduksId($this->produk->id)
                ->where('toko_id',  $this->toko->id)
                ->where('status_id', StatusService::final)
                ->where('created_at', '<', $log->created_at)
                ->orderBy('created_at', 'desc')
                ->first();

            LogBarangMasuk::whereId($log->id)->delete();
            $satuanTerkecilBarang = $this->jenisSatuanModel->find($this->produkRepository->find($prod->id)->satuan_jual_terkecil_id);
            $stoks = $this->stokRepository->model->where("produks_id",  $prod->id)->first();
            $konversiSebelumnya = KonversiSatuanService::konversi($prod->id, $log->satuan_beli_id, $log->jumlah_barang_masuk);
            $this->stokRepository->validate([
                'toko_id' => $this->toko->id,
                'produks_id' => $log->produks_id,
                'jumlah_sebelumnya' =>  $previousLog->jumlah_selebelumnya,
                'jumlah' => ($stoks->jumlah -  $konversiSebelumnya),
                'satuan_id' =>  $prod->satuan_jual_terkecil_id,
                'keterangan' => 'barang masuk',
                'status_id' => StatusService::final
            ])->createOrUpdate((empty($stoks) ? null : [
                "id" => $stoks->id,
                "data" => [
                    'jumlah_sebelumnya' =>  $previousLog->jumlah_selebelumnya,
                    'jumlah' => ($stoks->jumlah -  $konversiSebelumnya),
                ]
            ]));
            $this->data['produks_id'] = $this->produk->id;
            $this->initialize($this->data);
            $this->logBarangMasukRepository->validate([
                'kode' => $this->kode,
                'toko_id' => $this->toko->id,
                'user_id' =>  $this->actorService->authId(),
                'produks_id' => $this->produk->id,
                'supplier_id' => $this->suplier->id,
                'harga_beli' => $this->harga_beli, // harnga satuan
                'satuan_beli_id' => $this->jenisSatuan->id,
                'jumlah_selebelumnya' => $this->jumlah_sebelumnya,
                'jumlah_barang_masuk' => $this->jumlah_barang_masuk,
                'jumlah_barang_keluar' => 0,
                "stok_sisa" => $previousLog->jumlah_selebelumnya,
                'satuan_stok_id' => $satuanTerkecilBarang->id,
                'status_id' => StatusService::final,
            ])->create();
            $this->updateStok();
            return  $this;
        } catch (\Throwable $th) {
            throw new \Exception('stok: ' . $th->getMessage());
        }
    }

    // delete
    public function logProccessDelete()
    {
        $log = $this->logBarangMasukRepository->find($this->data['id']);
        $prod = $this->produkRepository->find($log->produks_id);
        try {
            $previousLog = LogBarangMasuk::whereProduksId($this->produk->id)
                ->where('toko_id',  $this->toko->id)
                ->where('status_id', StatusService::final)
                ->where('created_at', '<', $log->created_at)
                ->orderBy('created_at', 'desc')
                ->first();
            LogBarangMasuk::whereId($log->id)->delete();
            $satuanTerkecilBarang = $this->jenisSatuanModel->find($this->produkRepository->find($prod->id)->satuan_jual_terkecil_id);
            $stoks = $this->stokRepository->model->where("produks_id",  $prod->id)->first();
            $konversiSebelumnya = KonversiSatuanService::konversi($prod->id, $log->satuan_beli_id, $log->jumlah_barang_masuk);
            $this->stokRepository->validate([
                'toko_id' => $this->toko->id,
                'produks_id' => $log->produks_id,
                'jumlah_sebelumnya' =>  $previousLog->jumlah_selebelumnya,
                'jumlah' => ($stoks->jumlah -  $konversiSebelumnya),
                'satuan_id' =>  $prod->satuan_jual_terkecil_id,
                'keterangan' => 'barang masuk',
                'status_id' => StatusService::final
            ])->createOrUpdate((empty($stoks) ? null : [
                "id" => $stoks->id,
                "data" => [
                    'jumlah_sebelumnya' =>  $previousLog->jumlah_selebelumnya,
                    'jumlah' => ($stoks->jumlah -  $konversiSebelumnya),
                ]
            ]));
            return  $this;
        } catch (\Throwable $th) {
            throw new \Exception('stok: ' . $th->getMessage());
        }
    }
}
