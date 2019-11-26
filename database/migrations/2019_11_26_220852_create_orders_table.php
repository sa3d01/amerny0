<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('status',['waiting','assigned','on_the_way','arrived','canceled','done'])->default('waiting');
            $table->bigInteger('saved_place_id')->unsigned()->nullable();
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->json('services')->nullable();
            $table->bigInteger('shift_id')->unsigned()->nullable();
            $table->string('day')->nullable();
            $table->bigInteger('promo_code_id')->unsigned()->nullable();
            $table->text('note')->nullable();
            $table->json('images')->nullable();
            $table->bigInteger('provider_id')->unsigned()->nullable();
            $table->bigInteger('cancel_reason_id')->unsigned()->nullable();
            $table->timestamps();
        });
        Schema::table('orders', function($table) {
            $table->foreign('shift_id')->references('id')->on('shifts');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('provider_id')->references('id')->on('users');
            $table->foreign('cancel_reason_id')->references('id')->on('cancel_reasons');
            $table->foreign('saved_place_id')->references('id')->on('saved_places');
            $table->foreign('promo_code_id')->references('id')->on('promo_codes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
