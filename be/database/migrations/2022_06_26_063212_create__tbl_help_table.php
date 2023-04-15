<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblHelpTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_help', function (Blueprint $table) {
            $table->id();
            $table->string('fkey1');
            $table->string('fkey2');
            $table->string('data1');
            $table->string('data2')->nullable();
            $table->string('data3')->nullable();
            $table->string('data4')->nullable();
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
        Schema::dropIfExists('tbl_help');
    }
}
