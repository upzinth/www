<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_settings', function (Blueprint $table) {
            $table->integer('id');
            $table->string('email', 250)->nullable();
            $table->string('website', 250)->nullable();
            $table->string('app_version', 250)->nullable();
            $table->longText('about_us')->nullable();
            $table->text('header_images')->nullable();
            $table->longText('privacy_policy')->nullable();
            $table->longText('user_terms')->nullable();
            $table->string('facebook_url', 250)->nullable();
            $table->string('twitter_url', 250)->nullable();
            $table->string('youtube_url', 250)->nullable();
            $table->string('instagram_url', 250)->nullable();
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
        Schema::dropIfExists('app_settings');
    }
}
