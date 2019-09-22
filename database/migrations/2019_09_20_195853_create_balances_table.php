<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBalancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('balances', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->timestamp('date_open', 0);
            $table->integer('value_previous_close');
            $table->integer('value_open')->nullable();
            $table->text('observation')->default('')->nullable();
            $table->text('close')->default('0');
            $table->text('card')->default('0');
            $table->text('cash')->default('0');
            $table->text('sales')->default('0');

            $table->unsignedBigInteger('cashier_id');
            $table->foreign('cashier_id')->references('id')->on('cashiers');


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
        Schema::dropIfExists('balances');
    }
}
