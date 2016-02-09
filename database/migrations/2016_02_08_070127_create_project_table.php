<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('status', ['Budget Building', 'Open', 'Suspended', 'Complete'])->default('Budget Building');
            $table->string('name', 100);
            $table->string('description', 255)->nullable();
            $table->string('local_currency', 50);
            $table->integer('max_recipients')->unsigned()->default(0);
            $table->decimal('min_local_amount_per_recipient', 5, 2);
            $table->decimal('max_local_amount_per_recipient', 5, 2);
            $table->decimal('min_euro_amount_per_recipient', 5, 2);
            $table->decimal('max_euro_amount_per_recipient', 5, 2);
            $table->integer('updated_by')->unsigned();
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
        Schema::drop('project');
    }
}
