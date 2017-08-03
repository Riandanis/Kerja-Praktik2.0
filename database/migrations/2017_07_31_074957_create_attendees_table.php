<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttendeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendees', function (Blueprint $table) {
            $table->increments('id_attendee');
            $table->integer('id_rapat')->unsigned();
            $table->string('ket_attendee', 150);
            $table->timestamps();
        });

        Schema::table('attendees', function(Blueprint $table){
            $table->foreign('id_rapat')
                ->references('id_rapat')
                ->on('rapats')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attendees');
    }
}
