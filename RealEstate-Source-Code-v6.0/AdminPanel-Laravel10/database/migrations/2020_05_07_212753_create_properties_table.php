<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('property_type_id')->unsigned();
            $table->foreign('property_type_id')->references('id')->on('property_types');
            $table->bigInteger('property_category_id')->unsigned();
            $table->foreign('property_category_id')->references('id')->on('property_categories');
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->bigInteger('city_id')->unsigned();
            $table->foreign('city_id')->references('id')->on('cities');
            $table->boolean('featured')->nullable()->default(false);
            $table->string('title', 250);
            $table->longText('description');
            $table->text('image_names');
            $table->unsignedSmallInteger('size');
            $table->unsignedSmallInteger('bed_room_count');
            $table->unsignedSmallInteger('bath_room_count');
            $table->unsignedSmallInteger('kitchen_room_count');
            $table->unsignedSmallInteger('parking_count');
            $table->text('additional_features')->nullable();
            $table->decimal('price', 22, 2);
            $table->string('currency', 5);
            $table->text('address');
            $table->float('latitude', 9, 6);
            $table->float('longitude', 9, 6);
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
        Schema::dropIfExists('properties');
    }
}
