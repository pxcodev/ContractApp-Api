<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PayrollPayments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payroll_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('worker_id')->constrained('workers');
            $table->foreignId('contract_id')->constrained('contracts');
            $table->Integer('paidHours');
            $table->decimal('amount', 10, 2);
            $table->date('date');
            $table->string('receipt', 2500)->default('Not applicable');
            $table->foreignId('payment_method_id')->constrained('payment_methods');
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
        Schema::dropIfExists('payroll_payments');
    }
}
