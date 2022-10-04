<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegistDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('regist_documents', function (Blueprint $table) {
            $table->id();
            $table->integer('id_regist');
            $table->tinyInteger('document');
            $table->enum('status', ['N', 'Y'])->nullable();
            $table->string('name')->nullable();
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
        Schema::dropIfExists('regist_documents');
    }
}
