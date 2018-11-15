<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Class CreatePhotoAndPhotoAlbumTables
 */
class CreatePhotoAndPhotoAlbumTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('photo_albums', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_id')->nullable()->index();
            $table->string('uuid', 255);
            $table->string('name', 255);
            $table->string('label', 255)->index();
            $table->string('file', 255)->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('photos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('album_id')->index();
            $table->string('uuid', 255);
            $table->string('name', 255)->nullable()->index();
            $table->text('description')->nullable();
            $table->string('file_name', 255)->nullable()->index();
            $table->string('file', 255);
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
        // Not implemented...
    }
}
