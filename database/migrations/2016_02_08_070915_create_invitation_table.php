<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvitationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invitation', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('project_id')->unsigned();
            $table->string('email')->unique();
            $table->integer('user_role_id')->unsigned();
            $table->boolean('processed');
            $table->integer('updated_by')->unsigned();
            $table->timestamps();

            $table->foreign('project_id')->references('id')->on('project');
            $table->foreign('user_role_id')->references('id')->on('user_roles');

            $table->index('processed');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('invitation');
    }
}
