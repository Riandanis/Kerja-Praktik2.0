<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditColumnWaktuRapat extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rapats', function (Blueprint $table) {
            $table->dropColumn('waktu_rapat');
        });

        Schema::table('rapats', function (Blueprint $table) {
            $table->dateTime('waktu_rapat');
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
