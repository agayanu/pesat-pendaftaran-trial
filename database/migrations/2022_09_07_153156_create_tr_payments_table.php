<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tr_payments', function (Blueprint $table) {
            $table->id();
            $table->integer('id_pay');
            $table->integer('method');
            $table->date('transfer_date')->nullable();
            $table->string('transfer_no')->nullable();
            $table->string('remark')->nullable();
            $table->integer('amount');
            $table->date('tr_at');
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
        Schema::dropIfExists('tr_payments');
    }
}
