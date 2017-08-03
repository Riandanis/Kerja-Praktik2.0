<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTopiksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('topiks', function (Blueprint $table) {
            $table->increments('id_topik');
            $table->integer('id_agenda')->unsigned();
            $table->string('nama_topik', 150);
            $table->timestamps();
        });

        Schema::table('topiks', function(Blueprint $table){
            $table->foreign('id_agenda')
                ->references('id_agenda')
                ->on('agendas')
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
        Schema::dropIfExists('topiks');
    }
}
