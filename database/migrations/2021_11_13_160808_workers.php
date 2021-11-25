<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Workers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workers', function (Blueprint $table) {
            $table->id();
            $table->string('names', 250);
            $table->string('surnames');
            $table->string('identificationDocument');
            $table->string('gender');
            $table->string('nationality');
            $table->string('workerAddress', 250);
            $table->string('phone', 30);
            $table->date('registrationDate');
            $table->foreignId('worker_type_id')->constrained('worker_types');
            $table->decimal('hourly', 10, 2);
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
        Schema::dropIfExists('workers');
    }
}
