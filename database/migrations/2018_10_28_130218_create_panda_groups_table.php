<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePandaGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('panda_groups', function (Blueprint $table) {
            $table->increments('id');
            $table->text('name', 255);
            $table->text('slug', 255);
            $table->timestamps();
        });

        Schema::create('panda_groups_users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('panda_group_id')->index();
            $table->integer('user_id')->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('panda_groups');

        Schema::dropIfExists('panda_groups_users');
    }
}
