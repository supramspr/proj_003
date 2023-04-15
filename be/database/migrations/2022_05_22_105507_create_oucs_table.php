<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOucsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ouc', function (Blueprint $table) {
            $table->String('ouc', 4)->primary();
            $table->String('description', 50);
            $table->enum('status', ['1', '0'])->default('1');
            $table->String('created_by');
            $table->String('updated_by');
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
        Schema::dropIfExists('oucs');
    }
}
