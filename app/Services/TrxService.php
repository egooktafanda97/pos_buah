<?php

namespace App\Services;

use App\Constant\PayType;
use Illuminate\Support\Str;
use App\Dtos\ContainerTrx;
use App\Models\ConfigToko;
use App\Models\JenisSatuan;
use App\Models\Transaksi;
use App\Repositories\HargaRepository;
use App\Repositories\ProdukRepository;
use App\Repositories\StokDetailRepository;
use App\Repositories\StokRepository;
use App\Repositories\TrxRepository;
use App\Repositories\TrxTroliRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\callback;

class TrxService
{
    public $produk;
    public $toko;
    public $suplier;
    public $jenisSatuan;

    public function __construct(
        public ContainerTrx $containerTrx,
        public ActorService $actorService,
        public TrxRepository $trxRepository,
        public TrxTroliRepository $trxTroliRepository,
        public HargaRepository $hargaRepository,
        public ProdukRepository $produkRepository,
        public JenisSatuan $jenisSatuanModel,
        public StokRepository $stokRepository,
        public StokDetailRepository $stokDetailRepository
    ) {
    }

    public function middleware($next)
    {
        try {
            if ($totalbayar = $this->containerTrx->totalBayar < $this->containerTrx->getSubTotal())
                throw new \Exception("total bayar kurang dari total belanja : " . $this->containerTrx->totalBayar . " < " . $this->containerTrx->getSubTotal());
            return $next();
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }

    public function initialize($data)
    {
        if (!$this->actorService->kasir())
            throw new \Exception("kasir tidak ditemukan, silahkan login sebagai kasir");

        $this->containerTrx->data = $data;
        $this->containerTrx->toko = $this->actorService->toko();
        $this->containerTrx->kasir = $this->actorService->kasir();
        $this->containerTrx->setItems($this->produkRepository);
        $this->containerTrx->pelanggan = $this->actorService->pelanggan($data['pelanggan_id'] ?? null);
        $this->containerTrx->payment_type_id = $data['payment_type_id'] ?? null;
        $this->containerTrx->totalBayar = $data['total_bayar'] ?? 0;
        $this->containerTrx->diskon = $data['diskon'] ?? 0;
        $this->containerTrx->pph = $data['pph'] ?? ConfigToko::get('pph', 0);
        return $this;
    }

    public function summary()
    {
        return $this->containerTrx->getSubTotal();
    }

    public function trxProccessing(): Transaksi
    {
        DB::beginTransaction();
        try {
            $this->containerTrx->invoice =  Str::random(5);
            $this->containerTrx
                ->containerTrxClass =
                $this->middleware(function () {
                    return $this->trxRepository->validate(
                        [
                            'toko_id' => $this->containerTrx->toko->id,
                            'kasir_id' => $this->containerTrx->kasir->id,
                            'user_id' => $this->actorService->authId(),
                            'invoice' => $this->containerTrx->invoice,
                            'tanggal' => Carbon::now()->format("Y-m-d"),
                            'pelanggan_id' => $this->containerTrx->pelanggan,
                            'diskon' => $this->containerTrx->diskon,
                            'total_belanja' => $this->containerTrx->getSubTotal(),
                            'total_bayar' => $this->containerTrx->totalBayar,
                            'kembalian' => $this->containerTrx->getTotalKembali(),
                            'payment_type_id' => $this->containerTrx->payment_type_id ?? PayType::CASH,
                            'pph' => $this->containerTrx->pph,
                            'status_id' => StatusService::success,
                        ]
                    )->create(next: function ($trxData) {
                        $this->containerTrx->resultTrx = $trxData;
                        collect((object)$this->containerTrx->items)
                            ->map(function ($prod) use ($trxData) {
                                return $this->trxTroliRepository->validate([
                                    'toko_id' => $this->containerTrx->toko->id,
                                    'kasir_id' => $this->containerTrx->kasir->id,
                                    'user_id' => $this->actorService->authId(),
                                    'invoice' => $this->containerTrx->invoice,
                                    'transaksi_id' => $trxData->id,
                                    'produks_id' => $prod['id'],
                                    'harga_id' => $prod['harga_id'],
                                    'satuan_id' => $prod['satuan_beli'],
                                    'jumlah' => $prod['qty'],
                                    'total' => $prod['total'],
                                    'diskon' => $prod['diskon'] ?? 0,
                                    'status_id' => StatusService::success,
                                ])->create(next: function ($troli) use ($prod) {
                                    $stoks = $this->stokRepository->update($prod['id'], [
                                        "jumlah_sebelumnya" => $prod['stokBefore'],
                                        "jumlah" => $prod['stokAfter']
                                    ]);
                                    $this->stokDetailRepository
                                        ->validate([
                                            'stok_id' => $stoks->id,
                                            'toko_id' => $this->containerTrx->toko->id,
                                            'produks_id' => $prod['id'],
                                            "jumlah_sebelumnya" => $prod['stokBefore'],
                                            "jumlah" => $prod['stokAfter'],
                                            'satuan_id' => $prod['satuan_beli'],
                                            'tipe' => 'keluar'
                                        ])->create();
                                });
                            });
                    });
                });
            DB::commit();
            return $this->trxRepository->findWhereWith(
                where: function ($query) {
                    return $query->where("id", $this->containerTrx->resultTrx->id);
                },
                with: ['troli']
            );
        } catch (\Throwable $th) {
            DB::rollback();
            throw new \Exception('trx: ' . $th->getMessage());
        }
    }

    public function fackture($invoce)
    {
        $total =  $this->trxRepository->findWhereWith(
            where: function ($query) use ($invoce) {
                return $query->where("invoice", $invoce)
                    ->where("status_id", StatusService::success);
            },
            with: $this->trxRepository->withAll()
        );
        $totalItems = collect($total->troli)->sum('total');
        $diskon = $this->trxRepository->getSubTotalDiskon($totalItems, $total->diskon);
        $total_diskon = $totalItems -  $diskon ?? 0;
        $total->sub_total_diskon = $diskon ?? 0;
        $total->sub_total_pph = $this->trxRepository->getSubTotalPph($total_diskon ?? 0, $total->pph);
        return $total;
    }
    // history
    public function getList($data = null)
    {
        $items = $this->trxRepository->getWhere(
            where: function ($query) use ($data) {
                return $query->where("toko_id", $this->actorService->toko()->id)
                    ->when(!empty($data['rage']), function ($q) use ($data) {
                        return $q->whereBetween("tanggal", $data['rage']);
                    })
                    ->when(!empty($data['invoice']), function ($q) use ($data) {
                        return $q->where("invoice", $data['invoice']);
                    })
                    ->when(!empty($data['search']), function ($q) use ($data) {
                        return $q->where("invoice", "like", "%" . $data['search'] . "%")
                            ->orWhereHas('pelanggan', function ($q) use ($data) {
                                return $q->where("nama", "like", "%" . $data['search'] . "%");
                            })
                            ->orWhereHas('kasir', function ($q) use ($data) {
                                return $q->where("nama", "like", "%" . $data['search'] . "%");
                            });
                    })
                    ->where("status_id", StatusService::success);
            },
            with: $this->trxRepository->withAll()
        )->map(function ($trx) {
            $totalItems = collect($trx->troli)->sum('total');
            $diskon = $this->trxRepository->getSubTotalDiskon($totalItems, $trx->diskon);
            $total_diskon = $totalItems -  $diskon ?? 0;
            $trx->sub_total_diskon = $diskon ?? 0;
            $trx->sub_total_pph = $this->trxRepository->getSubTotalPph($total_diskon ?? 0, $trx->pph);
            return $trx;
        });
        return $items;
    }

    public function detailDTO(array $data)
    {
        return [
            "Invoice" => $data['invoice'],
            "Tanggal" => $data['tanggal'],
            "Kasir" => $data['kasir']['nama'],
            "Total Belanja" => "Rp. " . number_format($data['total_belanja']),
            "Diskon" => "(" . $data['diskon'] . " %) " .  "Rp. " . number_format($data['sub_total_diskon']),
            "Pph" => "(" . $data['pph'] . "%) " . "Rp. " . number_format($data['sub_total_pph']),
            "Total Bayar" => "Rp. " . number_format($data['total_bayar']),
            "Kembalian" => $data['kembalian'],
            "Metode Pembayaran" => $data['payment_type']['name'],
            "Status" => $data['status']['nama'],
            "Deskripsi Toko" => $data['toko']['deskripsi'],
            "Alamat Toko" => $data['toko']['alamat'],
            "Telepon Toko" => $data['toko']['telepon'],
            "Nama Pelanggan" => $data['pelanggan'] ? $data['pelanggan']['nama'] : "Tidak ada pelanggan",
            "Deskripsi Pembayaran" => $data['payment_type']['description']
        ];
    }

    public function ItemsDTO(array $data)
    {
        return collect($data['troli'])->map(function ($fx) {
            return [
                "Nama Produk" => $fx['produk']['nama_produk'],
                "Harga" =>  "Rp. " . number_format($fx['harga']['harga']),
                "Jumlah" => $fx['jumlah'] . " " . $fx['harga']['jenis_satuan']['nama'],
                "Total" => "Rp. " . number_format($fx['total']),
            ];
        });
    }

    // remove
    public function remove($invoice)
    {
        DB::beginTransaction();
        try {
            $trx = $this->trxRepository->findWhereWith(
                where: function ($query) use ($invoice) {
                    return $query->where("invoice", $invoice);
                },
                with: ['troli']
            );
            $this->trxRepository->update($trx->id, ['status_id' => StatusService::cancelle]);
            collect($trx->troli)->map(function ($fx) {
                $this->stokRepository->update($fx->produks_id, [
                    "jumlah_sebelumnya" => $fx->jumlah,
                    "jumlah" => $fx->jumlah + $fx->jumlah
                ]);
                $this->stokDetailRepository->validate([
                    'stok_id' => $fx->produks_id,
                    'toko_id' => $this->actorService->toko()->id,
                    'produks_id' => $fx->produks_id,
                    "jumlah_sebelumnya" => $fx->jumlah,
                    "jumlah" => $fx->jumlah + $fx->jumlah,
                    'satuan_id' => $fx->satuan_id,
                    'tipe' => 'masuk'
                ])->create();
            });
            DB::commit();
            return $trx;
        } catch (\Throwable $th) {
            DB::rollback();
            throw new \Exception($th->getMessage());
        }
    }
}
