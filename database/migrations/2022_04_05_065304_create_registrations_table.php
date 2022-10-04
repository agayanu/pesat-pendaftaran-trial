<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegistrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->smallInteger('period');
            $table->char('no_regist', 4);
            $table->tinyInteger('status');
            $table->tinyInteger('grade');
            $table->tinyInteger('major');
            $table->tinyInteger('phase');
            $table->string('name');
            $table->string('nickname', 50)->nullable();
            $table->string('place', 150)->nullable();
            $table->date('birthday')->nullable();
            $table->tinyInteger('religion');
            $table->tinyInteger('gender');
            $table->tinyInteger('citizen')->nullable();
            $table->string('birthday_id', 50)->nullable();
            $table->string('family_id', 50)->nullable();
            $table->enum('kip', ['N', 'Y'])->nullable();
            $table->enum('pip', ['N', 'Y'])->nullable();
            $table->enum('kps', ['N', 'Y'])->nullable();
            $table->string('kps_id')->nullable();
            $table->tinyInteger('family_status')->nullable();
            $table->tinyInteger('child_no')->nullable();
            $table->tinyInteger('child_qty')->nullable();
            $table->tinyInteger('blood')->nullable();
            $table->enum('glass', ['N', 'Y'])->nullable();
            $table->smallInteger('height')->nullable();
            $table->smallInteger('weight')->nullable();
            $table->smallInteger('head_size')->nullable();
            $table->float('distance', 4, 2)->nullable();
            $table->tinyInteger('time_hh')->nullable();
            $table->tinyInteger('time_mm')->nullable();
            $table->tinyInteger('transport')->nullable();
            $table->tinyInteger('stay')->nullable();
            $table->string('stay_rt', 10)->nullable();
            $table->string('stay_rw', 10)->nullable();
            $table->string('stay_village')->nullable();
            $table->smallInteger('stay_distric')->nullable();
            $table->smallInteger('stay_city')->nullable();
            $table->smallInteger('stay_province')->nullable();
            $table->text('stay_address')->nullable();
            $table->string('stay_postal', 5)->nullable();
            $table->string('stay_latitude')->nullable();
            $table->string('stay_longitude')->nullable();
            $table->string('home_rt', 10)->nullable();
            $table->string('home_rw', 10)->nullable();
            $table->string('home_village')->nullable();
            $table->smallInteger('home_distric')->nullable();
            $table->smallInteger('home_city')->nullable();
            $table->smallInteger('home_province')->nullable();
            $table->text('home_address')->nullable();
            $table->string('home_postal', 5)->nullable();
            $table->string('home_latitude')->nullable();
            $table->string('home_longitude')->nullable();
            $table->string('id_card', 50)->nullable();
            $table->string('hp_student', 20)->nullable();
            $table->string('hp_parent', 20)->nullable();
            $table->string('hp_parent2', 20)->nullable();
            $table->string('email_student')->nullable();
            $table->string('email_parent')->nullable();
            $table->string('email_parent2')->nullable();
            $table->smallInteger('school')->nullable();
            $table->smallInteger('school_year')->nullable();
            $table->float('school_nem_avg', 4, 2)->nullable();
            $table->float('school_sttb_avg', 4, 2)->nullable();
            $table->string('nisn', 20)->nullable();
            $table->string('exam_un_no', 30)->nullable();
            $table->string('skhun_no', 30)->nullable();
            $table->string('certificate_no', 30)->nullable();
            $table->string('photo')->nullable();
            $table->string('no_account', 50)->nullable();
            $table->string('no_account2', 50)->nullable();
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
        Schema::dropIfExists('registrations');
    }
}
