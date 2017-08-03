<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('actions', function (Blueprint $table) {
            $table->increments('id_action');
            $table->integer('id_diskusi')->unsigned();
            $table->string('deskripsi', 200);
            $table->date('due_date');
            $table->string('email_pic', 150);
            $table->string('jenis_action', 50);
            $table->string('solusi', 200);
            $table->boolean('status');
            $table->timestamps();
        });

        Schema::table('actions', function(Blueprint $table){
            $table->foreign('id_diskusi')
                ->references('id_diskusi')
                ->on('diskusis')
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
        Schema::dropIfExists('actions');
    }
}
