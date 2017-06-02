<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCouponTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupon_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type');
            $table->decimal('price_required')->default(0);
            $table->unsignedInteger('product_id_required')->nullable();
            $table->decimal('cut_price')->default(0);
            $table->decimal('cut_percentage')->default(0);
            $table->timestamps();

            $table->foreign('product_id_required')->references('id')->on('products');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('coupon_types', function(Blueprint $table) {
            $table->dropForeign('coupon_types_product_id_required_foreign');
        });
        Schema::drop('coupon_types');
    }
}
