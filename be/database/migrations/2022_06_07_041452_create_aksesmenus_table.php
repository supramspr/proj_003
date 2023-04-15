<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAksesmenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('akses_menu', function (Blueprint $table) {
            $table->id();
            $table->Integer('user_id');
            $table->String('name');
            $table->String('tam', 1);
            $table->String('lih', 1);
            $table->String('edi', 1);
            $table->String('hap', 1);
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
        Schema::dropIfExists('akses_menu');
    }
}
