<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchoolInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('school_infos', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('url');
            $table->string('nickname');
            $table->string('slogan');
            $table->text('address');
            $table->string('distric');
            $table->string('school_year');
            $table->string('chairman');
            $table->string('icon');
            $table->string('letter_head');
            $table->string('background');
            $table->string('regist_pdf_message_top');
            $table->string('regist_pdf_message_bottom');
            $table->string('wa_api')->nullable();
            $table->string('wa_api_key')->nullable();
            $table->text('regist_wa_message');
            $table->text('receive_wa_message');
            $table->text('pay_wa_message');
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
        Schema::dropIfExists('school_info');
    }
}
