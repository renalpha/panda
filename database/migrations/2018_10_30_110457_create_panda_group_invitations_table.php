<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePandaGroupInvitationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('panda_group_invitations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('panda_group_id')->index();
            $table->integer('user_id')->index();
            $table->string('invitation_code', 255);
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
        Schema::dropIfExists('panda_group_invitations');
    }
}
