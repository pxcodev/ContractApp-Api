<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ContractStatus;

class ContractStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ContractStatus::create([
            'name'             =>    'Completed',
        ]);
        ContractStatus::create([
            'name'             =>    'In Progress',
        ]);
        ContractStatus::create([
            'name'             =>    'Wait For Money',
        ]);
    }
}
