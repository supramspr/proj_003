<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdjbiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adj_bi', function (Blueprint $table) {
            $table->Increments('id');
            $table->date('tanggal');
            $table->string('ouc', 8);
            $table->string('gl_account', 12);
            $table->decimal('amount', 15, 2);
            $table->string('notes');
            $table->string('created_by', 20);
            $table->string('status', 1);
            $table->bigInteger('media_id');
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
        Schema::dropIfExists('adj_bi');
    }
}
