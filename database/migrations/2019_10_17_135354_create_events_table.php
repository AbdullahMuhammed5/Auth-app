<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('main_title', 150);
            $table->string('secondary_title', 150)->nullable();
            $table->string('location', 100);
            $table->double('address_latitude');
            $table->double('address_longitude');
            $table->text('content');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->string('cover', 250);
            $table->boolean('published')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
    }
}
