<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgendasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agendas', function (Blueprint $table) {
            $table->increments('id_agenda');
            $table->integer('id_rapat')->unsigned();
            $table->string('nama_agenda', 150);
            $table->timestamps();
        });

        Schema::table('agendas', function(Blueprint $table){
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
        Schema::dropIfExists('agendas');
    }
}
