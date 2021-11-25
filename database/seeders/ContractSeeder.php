<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Contract;

class ContractSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // Contract::create([
        //     'name'             =>    'Contrato 1',
        //     'contractAddress'             =>    'Direccion 1',
        //     'contract_type'             =>    $this->faker->randomElement(['Male', 'Female']),
        //     'startDate'             =>    '2021-11-14',
        //     'endDate'             =>    '2021-11-14',
        //     'totalCost'             =>    1500,
        //     'status'             =>    'Completed',
        //     'delete'             =>    0
        // ]);
        Contract::factory(10)->create();
    }
}
