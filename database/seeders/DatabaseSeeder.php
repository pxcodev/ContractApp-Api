<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ContractTypeSeeder::class);
        $this->call(ContractStatusSeeder::class);
        $this->call(ContractSeeder::class);
        $this->call(WorkerTypeSeeder::class);
        $this->call(WorkerSeeder::class);
        $this->call(AssignmentSeeder::class);
        $this->call(AssistanceSeeder::class);
        $this->call(PaymentSeeder::class);
    }
}
