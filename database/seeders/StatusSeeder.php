<?php

namespace Database\Seeders;

use App\Models\Status;
use App\Services\StatusService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function __construct(
        public StatusService $status
    ) {
    }
    public function run(): void
    {
        Status::insert($this->status->dbSeederItems());
    }
}
