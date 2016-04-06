<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSponsoredRecipientTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sponsored_recipient', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('project_member_id')->unsigned();
            $table->integer('recipient_member_id')->unsigned();
            $table->enum('status', ['Active', 'Suspended', 'Cancelled'])->default('Active');
            $table->timestamp('next_due');
            $table->decimal('euro_amount_promised', 9, 2);
            $table->integer('updated_by')->unsigned();
            $table->timestamps();

            $table->foreign('project_member_id')->references('id')->on('project_member');
            $table->foreign('recipient_member_id')->references('id')->on('project_member');

            $table->unique(['project_member_id', 'recipient_member_id']);
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('sponsored_recipient');
    }
}
