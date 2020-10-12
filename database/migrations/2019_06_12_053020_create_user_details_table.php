<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserDetailsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('user_details', function (Blueprint $table) {
            $table->integer('user_id')->unsigned()->primary('user_id');
            $table->string('first_name', 50);
            $table->string('last_name', 50)->default('');
            $table->string('nic', 12)->default('');
            $table->enum('gender', ['male', 'female']);
            $table->date('dob');
            $table->integer('birth_district_id')->unsigned()->nullable();
            $table->string('highest_edu_qualification', 50)->default('');
            $table->string('current_work_place', 20)->default('');
            $table->string('registration_no', 20)->default('');
            $table->string('prof_pic', 50)->nullable();
            $table->string('professional', 50)->default('');
            $table->string('vtc', 50)->default('');
            $table->boolean('is_complete_profile')->default(false);
            $table->integer('referral_point')->unsigned()->nullable();
            $table->string('referral_no', 6)->default('');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('birth_district_id')->references('id')->on('districts');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('user_details');
    }
}
