<?php

namespace App\Dtos;

use App\Repositories\ProdukRepository;

class ContainerTrx
{
    public array $data;
    public $invoice;
    public  $produk;
    public  $toko;
    public $kasir;
    public  $suplier;
    public  $pelanggan;
    public  $jenisSatuan;
    public $diskon = 0;
    public $pph;
    public int  $totalOrder;
    public  $troli;
    public array $items = [];
    public string | int | null $payment_type_id;
    public $totalBayar = 0;
    public $containerTrxClass;
    public $ItemTroliCollection;
    public $resultTrx;
    public $initStok;
    public $afterStok;

    public function setPph($pph)
    {
        $this->pph = $pph;
        return $this;
    }

    public function getPph($total)
    {
        if ($this->pph != 0)
            return $total * ($this->pph / 100);
        return 0;
    }

    public function setDiskon($diskon)
    {
        $this->diskon = $diskon;
        return $this;
    }

    public function getDiskon()
    {
        if ($this->diskon != 0)
            return $this->totalOrder * ($this->diskon / 100);
        return 0;
    }

    public function totalDiskon(): int
    {
        if ($this->diskon != 0)
            return  $this->diskon = $this->totalOrder * ($this->diskon / 100);
        return $this->diskon;
    }

    public function getSubTotal()
    {
        $totalOrder = ($this->totalOrder - $this->getDiskon());
        $pph = +$this->getPph($totalOrder);
        $subtotal = $totalOrder + $pph;
        return $subtotal;
    }

    public function getTotalKembali()
    {
        return $this->totalBayar - $this->getSubTotal();
    }

    public function setItems(ProdukRepository $produkRepository)
    {
        $this->items = collect($this->data['items'])->map(function ($px) use ($produkRepository) {
            return $produkRepository->getPrieces(
                id: $px['id'],
                unit: $px['satuan'],
                qty: $px['qty']
            );
        })->toArray();
        $this->totalOrder = collect($this->items)->sum('total');
        return $this;
    }


    //getAll property
    public function getAll()
    {
        return [
            'produk' => $this->produk,
            'toko' => $this->toko,
            'kasir' => $this->kasir,
            'suplier' => $this->suplier,
            'pelanggan' => $this->pelanggan,
            'jenisSatuan' => $this->jenisSatuan,
            'troli' => $this->troli,
            'items' => $this->items,
            'payment_type_id' => $this->payment_type_id
        ];
    }
}
