<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanyPostBookmarksTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('company_post_bookmarks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_post_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->timestamps();

            $table->unique(['company_post_id', 'user_id']);
            $table->foreign('company_post_id')->references('id')->on('company_posts')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('company_post_bookmarks');
    }
}
