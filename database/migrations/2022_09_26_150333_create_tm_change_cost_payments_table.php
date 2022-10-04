<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTmChangeCostPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tm_change_cost_payments', function (Blueprint $table) {
            $table->id();
            $table->smallInteger('phase');
            $table->integer('id_cost_payment_from');
            $table->integer('id_cost_payment_to');
            $table->integer('change_amount');
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
        Schema::dropIfExists('tm_change_cost_payments');
    }
}
