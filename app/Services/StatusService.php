<?php

namespace App\Services;

class StatusService
{
    const Active = 1;      // status aktif
    const inActive = 2;    // status tidak aktif
    const pending = 3;     // status menunggu
    const returned = 4;    // status dikembalikan
    const fail = 5;        // status gagal
    const paid = 6;        // status dibayar
    const unpaid = 7;      // status belum dibayar
    const debit = 8;       // status debit
    const credit = 9;      // status kredit
    const success = 10;    // status sukses
    const final = 11;      // status final
    const cancelle = 12;   // status dibatalkan
    const transfer = 13;   // status transfer
    const block = 14;      // status diblokir
    const created = 15;    // status dibuat
    const debts = 16;      // status 

    public function dbSeederItems()
    {
        return [
            [
                'id' => self::Active,
                'nama' => 'Active',
            ],
            [
                'id' => self::inActive,
                'nama' => 'inActive',
            ],
            [
                'id' => self::pending,
                'nama' => 'pending',
            ],
            [
                'id' => self::returned,
                'nama' => 'returned',
            ],
            [
                'id' => self::fail,
                'nama' => 'fail',
            ],
            [
                'id' => self::paid,
                'nama' => 'paid',
            ],
            [
                'id' => self::unpaid,
                'nama' => 'unpaid',
            ],
            [
                'id' => self::debit,
                'nama' => 'debit',
            ],
            [
                'id' => self::credit,
                'nama' => 'credit',
            ],
            [
                'id' => self::success,
                'nama' => 'success',
            ],
            [
                'id' => self::final,
                'nama' => 'final',
            ],
            [
                'id' => self::cancelle,
                'nama' => 'cancelle',
            ],
            [
                'id' => self::transfer,
                'nama' => 'transfer',
            ],
            [
                'id' => self::block,
                'nama' => 'block',
            ],
            [
                'id' => self::created,
                'nama' => 'created',
            ],
            [
                'id' => self::debts,
                'nama' => 'debts',
            ],
        ];
    }
}
