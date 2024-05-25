<?php

namespace App\Services;

use App\Constant\PayType;
use Illuminate\Support\Str;
use App\Dtos\ContainerTrx;
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
        $this->containerTrx->data = $data;
        $this->containerTrx->toko = $this->actorService->toko();
        $this->containerTrx->kasir = $this->actorService->kasir();
        $this->containerTrx->setItems($this->produkRepository);
        $this->containerTrx->pelanggan = $this->actorService->pelanggan($data['pelanggan_id'] ?? null);
        $this->containerTrx->payment_type_id = $data['payment_type_id'] ?? null;
        $this->containerTrx->totalBayar = $data['total_bayar'] ?? 0;
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
                            'diskon' => 0,
                            'total_belanja' => $this->containerTrx->getSubTotal(),
                            'total_bayar' => $this->containerTrx->totalBayar,
                            'kembalian' => $this->containerTrx->getTotalKembali(),
                            'payment_type_id' => $this->containerTrx->payment_type_id ?? PayType::CASH,
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
                                    'diskon' => 0,
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
            throw new \Exception($th->getMessage());
        }
    }
}
