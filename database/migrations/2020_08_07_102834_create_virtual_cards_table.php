<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVirtualCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('virtual_cards', function (Blueprint $table) {
            $table->id();
            $table->string('currency');
            $table->float('amount');
            $table->string('billing_name');
            $table->string('billing_country');
            $table->string('billing_address');
            $table->string('billing_city');
            $table->string('billing_state');
            $table->string('billing_postal_code');
            $table->string('reference');
            $table->string('name_on_card')->nullable();
            $table->string('status')->nullable();
            $table->string('message')->nullable();
            $table->string('card_id')->nullable();
            $table->string('callback_url')->nullable();
            $table->string('card_pan')->nullable();
            $table->string('masked_pan')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('address_1')->nullable();
            $table->string('address_2')->nullable();
            $table->string('zip_code')->nullable();
            $table->integer('cvv')->nullable();
            $table->string('expiration')->nullable();
            $table->string('send_to')->nullable();
             $table->string('bin_check_name')->nullable();
            $table->string('card_type')->nullable();
             $table->boolean('is_active')->nullable();
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
        Schema::dropIfExists('virtual_cards');
    }
}