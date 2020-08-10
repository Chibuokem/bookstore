<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFlutterwavehookslogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flutterwavehookslog', function (Blueprint $table) {
            $table->id();
            $table->text('body')->nullable();
            $table->string('reference')->nullable();
            $table->string('transaction_status')->nullable();
            $table->integer('transaction_id')->nullable();
            
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
        Schema::dropIfExists('flutterwavehookslog');
    }
}