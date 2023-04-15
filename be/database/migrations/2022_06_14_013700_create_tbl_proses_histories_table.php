<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblProsesHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_proses_histori', function (Blueprint $table) {
            $table->id();
            $table->date('period');
            $table->string('name_menu');
            $table->string('ouc', 8);
            $table->string('lstatus', 1);
            $table->string('status', 1);
            $table->string('level_1', 1)->nullable();
            $table->string('level_2', 1)->nullable();
            $table->string('level_3', 1)->nullable();
            $table->integer('user_id');
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
        Schema::dropIfExists('tbl_proses_histori');
    }
}
