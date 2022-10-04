<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTmNoaccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tm_noaccounts', function (Blueprint $table) {
            $table->id();
            $table->string('account', 20);
            $table->tinyInteger('account_digit');
            $table->string('account_min', 50);
            $table->string('account_max', 50);
            $table->string('account2', 20);
            $table->tinyInteger('account2_digit');
            $table->string('account2_min', 50);
            $table->string('account2_max', 50);
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
        Schema::dropIfExists('tm_noaccounts');
    }
}
