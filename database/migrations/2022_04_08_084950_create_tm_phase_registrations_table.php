<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTmPhaseRegistrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tm_phase_registrations', function (Blueprint $table) {
            $table->id(); 
            $table->smallInteger('period');
            $table->string('name', 100);
            $table->enum('status', ['N', 'Y']);
            $table->enum('cost', ['N', 'Y']);
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
        Schema::dropIfExists('tm_phase_registrations');
    }
}
