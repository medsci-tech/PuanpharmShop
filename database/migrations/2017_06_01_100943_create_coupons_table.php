<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('coupon_type_id');
            $table->unsignedInteger('customer_id');
            $table->boolean('used')->default(0);
            $table->timestamps();

            $table->foreign('coupon_type_id')->references('id')->on('coupon_types');
            $table->foreign('customer_id')->references('id')->on('customers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('coupons', function (Blueprint $table) {
            $table->dropForeign('coupons_coupon_type_id_foreign');
            $table->dropForeign('coupons_customer_id_foreign');
        });
        Schema::drop('coupons');
    }
}
