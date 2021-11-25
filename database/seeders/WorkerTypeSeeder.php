<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\WorkerType;

class WorkerTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // WorkerType::factory(10)->create();
        WorkerType::create([
            'name'             =>    'Daily worker',
        ]);
        WorkerType::create([
            'name'             =>    'Contractor worker',
        ]);
    }
}
