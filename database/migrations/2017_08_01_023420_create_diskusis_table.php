<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiskusisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('diskusis', function (Blueprint $table) {
            $table->increments('id_diskusi');
            $table->integer('id_topik')->unsigned();
            $table->string('nama_diskusi', 150);
            $table->timestamps();
        });

        Schema::table('diskusis', function(Blueprint $table){
            $table->foreign('id_topik')
                ->references('id_topik')
                ->on('topiks')
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
        Schema::dropIfExists('diskusis');
    }
}
