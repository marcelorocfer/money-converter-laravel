<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('money_converters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->string('target_currency');
            $table->string('value_to_be_converted');
            $table->string('payment_method');
            $table->string('target_currency_value');
            $table->string('target_currency_purchased_value');
            $table->string('payment_tax');
            $table->string('conversion_tax');
            $table->string('total_amount_with_taxes');
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
        Schema::dropIfExists('money_converters');
    }
};
