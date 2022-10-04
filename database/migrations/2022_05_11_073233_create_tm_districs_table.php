<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTmDistricsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tm_districs', function (Blueprint $table) {
            $table->id();
            $table->string('code', 12);
            $table->string('name');
            $table->string('code_city', 8);
            $table->string('code_province', 4);
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
        Schema::dropIfExists('tm_districs');
    }
}
