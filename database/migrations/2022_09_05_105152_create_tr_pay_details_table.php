<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrPayDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tr_pay_details', function (Blueprint $table) {
            $table->id();
            $table->integer('id_pay');
            $table->integer('id_cost_payment_detail');
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
        Schema::dropIfExists('tr_pay_details');
    }
}
