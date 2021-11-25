<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Contracts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->string('name', 250);
            $table->string('contractAddress', 250);
            $table->foreignId('contract_type_id')->constrained('contract_types');
            $table->foreignId('contract_status_id')->constrained('contract_status');
            $table->date('startDate');
            $table->date('endDate');
            $table->decimal('totalCost')->default('0.00');
            $table->boolean('delete')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contracts');
    }
}
