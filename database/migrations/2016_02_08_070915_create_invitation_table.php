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
            $table->string('role_type', 50);
            $table->boolean('processed');
            $table->integer('updated_by')->unsigned();
            $table->timestamps();

            $table->foreign('project_id')->references('id')->on('project');

            $table->index('processed');
            $table->index('role_type');
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
