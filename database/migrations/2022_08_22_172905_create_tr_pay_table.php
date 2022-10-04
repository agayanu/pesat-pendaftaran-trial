<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrPayTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tr_pay', function (Blueprint $table) {
            $table->id();
            $table->integer('id_regist');
            $table->integer('id_cost_payment');
            $table->integer('bill');
            $table->integer('amount')->nullable();
            $table->integer('balance');
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
        Schema::dropIfExists('tr_pay');
    }
}
