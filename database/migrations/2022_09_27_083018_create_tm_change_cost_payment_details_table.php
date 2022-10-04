<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTmChangeCostPaymentDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tm_change_cost_payment_details', function (Blueprint $table) {
            $table->id();
            $table->integer('id_change_cost');
            $table->integer('id_detail_master');
            $table->smallInteger('myorder');
            $table->integer('amount_from');
            $table->integer('amount_to')->nullable();
            $table->integer('change_amount')->nullable();
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
        Schema::dropIfExists('tm_change_cost_payment_details');
    }
}
