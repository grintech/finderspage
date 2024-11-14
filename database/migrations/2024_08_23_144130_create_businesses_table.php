<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBusinessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('businesses', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('business_name');
            $table->string('slug');
            $table->string('sub_category');
            $table->string('add_button');
            $table->string('add_button_input');
            $table->string('choice');
            $table->string('parking');
            $table->string('business_email');
            $table->string('business_phone');
            $table->string('business_website');
            $table->string('address_1');
            $table->string('address_2');
            $table->string('status');
            $table->string('country');
            $table->string('state');
            $table->string('city');
            $table->string('zip_code');
            $table->string('location');
            $table->string('opening_hours');
            $table->string('video');
            $table->string('gallery_image');
            $table->string('business_logo');
            $table->string('facebook');
            $table->string('youtube');
            $table->string('instagram');
            $table->string('tiktok');
            $table->string('whatsapp');
            $table->longtext('business_description');
            $table->enum('type', ['Featured', 'Normal', 'Bump']);
            $table->enum('draft', [0, 1]);
            $table->string('featured');
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
        Schema::dropIfExists('businesses');
    }
}
