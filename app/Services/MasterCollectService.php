<?php

namespace App\Services;

use App\Models\JenisProduk;
use App\Models\JenisSatuan;
use App\Models\Konversisatuan;
use App\Models\PaymentType;
use Faker\Provider\ar_EG\Payment;

class MasterCollectService
{
    private $collection;

    public function __construct(
        public JenisProduk $jenisProduk,
        public JenisSatuan $jenisSatuan,
        public Konversisatuan $konversisatuan,
        public PaymentType $paymentType,
        public StatusService $statusService,
    ) {
    }

    public function jenisProduk()
    {
        $this->collection = $this->jenisProduk;
        return $this;
    }

    public function jenisSatuan()
    {
        $this->collection = $this->jenisSatuan;
        return $this;
    }

    public function konversisatuan()
    {
        $this->collection = $this->konversisatuan;
        return $this;
    }

    public function paymentType()
    {
        $this->collection = $this->paymentType;
        return $this;
    }

    public function statusService()
    {
        $this->collection = $this->statusService;
        return $this;
    }




    public function getAll()
    {
        return $this->collection->get();
    }
    public function getId($id)
    {
        return $this->collection->find($id);
    }
}
