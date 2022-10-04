<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTmCostPaymentDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tm_cost_payment_details', function (Blueprint $table) {
            $table->id();
            $table->integer('id_payment');
            $table->integer('id_detail_master');
            $table->smallInteger('myorder');
            $table->integer('amount');
            $table->string('description')->nullable();
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
        Schema::dropIfExists('tm_cost_payment_details');
    }
}
