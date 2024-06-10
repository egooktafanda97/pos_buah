<?php

namespace Database\Seeders;

use App\Models\Config;
use App\Models\ConfigToko;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ConfigToko::insert([
            [
                'toko_id' => 1,
                'key' => 'ppn',
                'value' => '10',
                'description' => 'pajak ppn',
            ]
        ]);

        Config::insert([
            [
                'key' => 'app_name',
                'value' => 'POS',
                'description' => 'Nama Aplikasi',
            ],
            [
                'key' => 'app_version',
                'value' => '1.0.0',
                'description' => 'Versi Aplikasi',
            ],
            [
                'key' => 'app_description',
                'value' => 'Aplikasi Point of Sale',
                'description' => 'Deskripsi Aplikasi',
            ],
            [
                'key' => 'app_logo',
                'value' => 'logo.png',
                'description' => 'Logo Aplikasi',
            ],
            [
                'key' => 'app_icon',
                'value' => 'icon.png',
                'description' => 'Icon Aplikasi',
            ],
            [
                'key' => 'app_favicon',
                'value' => 'favicon.png',
                'description' => 'Favicon Aplikasi',
            ],
            [
                'key' => 'app_theme',
                'value' => 'light',
                'description' => 'Tema Aplikasi',
            ],
            [
                'key' => 'app_layout',
                'value' => 'vertical',
                'description' => 'Layout Aplikasi',
            ],
            [
                'key' => 'app_sidebar',
                'value' => 'compact',
                'description' => 'Sidebar Aplikasi',
            ],
            [
                'key' => 'app_sidebar_type',
                'value' => 'default',
                'description' => 'Tipe Sidebar Aplikasi',
            ],
            [
                'key' => 'app_sidebar_position',
                'value' => 'fixed',
                'description' => 'Posisi Sidebar Aplikasi',
            ],
            [
                'key' => 'app_header',
                'value' => 'fixed',
                'description' => 'Header Aplikasi',
            ],
            [
                'key' => 'app_footer',
                'value' => 'fixed',
                'description' => 'Footer Aplikasi',
            ],
            [
                'key' => 'app_boxed_layout',
                'value' => 'full',
                'description' => 'Layout Boxed Aplikasi',
            ],
        ]);
    }
}
