<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectMemberTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_member', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('project_id')->unsigned();
            $table->integer('user_role_id')->unsigned();
            $table->enum('status', ['Active', 'Suspended', 'Cancelled'])->default('Active');
            $table->integer('updated_by')->unsigned();
            $table->timestamps();

            $table->foreign('project_id')->references('id')->on('project');
            $table->foreign('user_role_id')->references('id')->on('user_roles');

            $table->unique('project_id', 'user_role_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('project_member');
    }
}
