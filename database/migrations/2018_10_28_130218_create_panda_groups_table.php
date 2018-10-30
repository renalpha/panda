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
            $table->string('name', 255);
            $table->string('label', 255);
            $table->timestamps();
        });

        Schema::create('panda_group_roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 255);
            $table->string('label', 255);
        });

        Schema::create('panda_groups_users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('panda_group_id')->index();
            $table->integer('user_id')->index();
            $table->integer('panda_group_role_id')->index();
        });

        \Domain\Entities\PandaGroup\PandaGroupRole::create([
            'name' => 'Admin',
            'label' => 'admin'
        ]);

        \Domain\Entities\PandaGroup\PandaGroupRole::create([
            'name' => 'Member',
            'label' => 'member'
        ]);
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
