<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLatestPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('latest_posts', function (Blueprint $table) {
            $table->id();
            $table->Integer('user_id'); 
            $table->Integer('to_id'); 
            $table->Integer('post_id'); 
            $table->Integer('category'); 
            $table->string('type');
            $table->enum('status', [0,1]);
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
        Schema::dropIfExists('latest_posts');
    }
}
