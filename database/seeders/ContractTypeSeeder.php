<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ContractType;

class ContractTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ContractType::create([
            'name'             =>    'General contract',
        ]);
        ContractType::create([
            'name'             =>    'Provide workers',
        ]);
    }
}
