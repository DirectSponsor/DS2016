<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction', function (Blueprint $table) {
            $table->increments('id');
            $table->date('due_date')->default(NULL);
            $table->string('month', 3)->default(NULL);
            $table->enum('status', ['Pending', 'Confirmed', 'Late'])->default('Pending');
            $table->enum('trans_type', ['Receipt', 'Fund Receipt', 'Fund Expense'])->default(NULL);
            $table->integer('project_member_id')->unsigned();
            $table->integer('sender_member_id')->unsigned();
            $table->decimal('euro_amount', 5, 2);
            $table->decimal('local_amount', 5, 2);
            $table->integer('updated_by')->unsigned();
            $table->timestamps();

            $table->foreign('project_member_id')->references('id')->on('project_member');
            $table->foreign('sender_member_id')->references('id')->on('project_member');

            $table->index('trans_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('transaction');
    }
}
