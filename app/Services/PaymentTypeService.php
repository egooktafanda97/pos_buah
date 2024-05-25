<?php

namespace App\Services;

class PaymentTypeService
{
    const Cash = 1;
    const Credit = 2;
    const Debit = 3;
    const Transfer = 4;
    const OVO = 5;
    const Dana = 6;
    const LinkAja = 7;
    const Gopay = 8;

    public function dbSeederItems()
    {
        return [
            [
                'id' => self::Cash,
                'name' => 'Cash',
            ],
            [
                'id' => self::Credit,
                'name' => 'Credit',
            ],
            [
                'id' => self::Debit,
                'name' => 'Debit',
            ],
            [
                'id' => self::Transfer,
                'name' => 'Transfer',
            ],
            [
                'id' => self::OVO,
                'name' => 'OVO',
            ],
            [
                'id' => self::Dana,
                'name' => 'Dana',
            ],
            [
                'id' => self::LinkAja,
                'name' => 'LinkAja',
            ],
            [
                'id' => self::Gopay,
                'name' => 'Gopay',
            ],
        ];
    }
}
