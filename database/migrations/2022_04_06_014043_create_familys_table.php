<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFamilysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('familys', function (Blueprint $table) {
            $table->id();
            $table->integer('id_regist');
            $table->tinyInteger('family_member');
            $table->string('name')->nullable();
            $table->string('place', 150)->nullable();
            $table->date('birthday')->nullable();
            $table->string('id_card', 100)->nullable();
            $table->tinyInteger('religion')->nullable();
            $table->tinyInteger('education')->nullable();
            $table->tinyInteger('job')->nullable();
            $table->tinyInteger('income')->nullable();
            $table->text('remark')->nullable();
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
        Schema::dropIfExists('familys');
    }
}
