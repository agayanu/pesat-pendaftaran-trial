<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTmProvincesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tm_provinces', function (Blueprint $table) {
            $table->id();
            $table->string('code', 4);
            $table->string('name');
            $table->tinyInteger('order');
            $table->enum('active', ['N', 'Y'])->default('Y');
            $table->timestamps();
            $table->index('code');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tm_provinces');
    }
}
