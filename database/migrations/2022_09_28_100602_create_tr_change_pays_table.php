<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrChangePaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tr_change_pays', function (Blueprint $table) {
            $table->id();
            $table->integer('id_pay');
            $table->integer('id_change_cost');
            $table->integer('bill_from');
            $table->integer('bill_to');
            $table->integer('amount');
            $table->integer('balance_from');
            $table->integer('balance_to');
            $table->string('user');
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
        Schema::dropIfExists('tr_change_pays');
    }
}
