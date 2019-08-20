<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTruismsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('truisms', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('author');
            $table->text('truism');
            $table->integer('haha')->default(0)->unsigned();
            $table->integer('meh')->default(0)->unsigned();
            $table->text('interactions');
            $table->text('seenBy');
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
        Schema::dropIfExists('truisms');
    }
}
