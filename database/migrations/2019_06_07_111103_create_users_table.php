<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email', 50)->unique();
            $table->string('mobile_no', 12)->unique();
            $table->string('password');
            $table->text('api_key')->nullable();
            $table->enum('role', ['client', 'admin'])->default('client');
            $table->enum('oauth_provider', ['', 'facebook', 'google'])->default('');
            $table->string('oauth_uid', 100)->nullable();
            $table->string('sms_ref_id', 50)->default('');
            $table->boolean('is_active')->default(false);
            $table->timestamps();

            $table->unique(['oauth_provider', 'oauth_uid']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
