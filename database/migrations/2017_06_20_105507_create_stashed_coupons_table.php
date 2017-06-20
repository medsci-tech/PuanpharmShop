<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStashedCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stashed_coupons', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('coupon_type_id');
            $table->boolean('delivered')->default(0);
            $table->string('unionid');
            $table->string('source');
            $table->timestamps();
            $table->timestamp('delivered_at')->nullable();
            $table->timestamp('expire_at')->nullable();

            $table->index('unionid');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('stashed_coupons');
    }
}
