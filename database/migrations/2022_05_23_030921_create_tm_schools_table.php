<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTmSchoolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tm_schools', function (Blueprint $table) {
            $table->id();
            $table->string('code', 15)->nullable();
            $table->string('name');
            $table->text('address')->nullable();
            $table->enum('status', ['NEGERI', 'SWASTA']);
            $table->string('code_province', 4)->nullable();
            $table->string('code_city', 8)->nullable();
            $table->string('code_distric', 12)->nullable();
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
        Schema::dropIfExists('tm_schools');
    }
}
