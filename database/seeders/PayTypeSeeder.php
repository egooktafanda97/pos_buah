<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PayTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('payment_types')->insert([
            [
                'name' => 'Credit Card',
                'description' => 'Pay using credit card',
                'icon' => 'credit_card_icon.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'PayPal',
                'description' => 'Pay using PayPal account',
                'icon' => 'paypal_icon.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Bank Transfer',
                'description' => 'Transfer to our bank account',
                'icon' => 'bank_transfer_icon.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Cash',
                'description' => 'Pay with cash on delivery',
                'icon' => 'cash_icon.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Cryptocurrency',
                'description' => 'Pay using cryptocurrency',
                'icon' => 'crypto_icon.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
