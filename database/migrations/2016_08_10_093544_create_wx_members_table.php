<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWxMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wx_members', function (Blueprint $table) {
            $table->increments('id');
            $table->string('phone', 31)->nullable();
            $table->unique('phone');
            $table->string('openid')->nullable();
//            $table->unique('openid');
            $table->string('source')->nullable();
            $table->timestamps();
        });

        Schema::create('wx_member_addresses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('wx_member_id')->unsigned()->nullable();
            $table->boolean('default')->default(0);
            $table->string('phone', 20);
            $table->string('name', 100);
            $table->integer('zipcode');
            $table->string('province');
            $table->string('city');
            $table->string('district', 50)->nullable();
            $table->text('address');
            $table->timestamps();
            $table->foreign('wx_member_id')->references('id')->on('wx_members');
        });

        Schema::create('wx_member_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('order_sn');
            $table->string('out_trade_no');
            $table->string('shipping_no');
            $table->decimal('total_fee')->default(0.00);
            $table->decimal('beans_fee')->default(0.00);
            $table->decimal('shipping_fee')->default(0.00);
            $table->decimal('products_fee')->default(0.00);
            $table->tinyInteger('status');
            $table->tinyInteger('payment_status');
            $table->dateTime('delivered_at')->nullable();
            $table->string('remark')->nullable();
            $table->string('address_phone', 20);
            $table->string('address_name', 100);
            $table->string('address_province');
            $table->string('address_city');
            $table->string('address_district', 50);
            $table->text('address_detail');
            $table->integer('wx_member_id')->unsigned();
            $table->foreign('wx_member_id')->references('id')->on('wx_members');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('product_wx_member_order', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('wx_member_order_id')->unsigned();
            $table->integer('product_id')->unsigned();
            $table->integer('quantity');
            $table->integer('specification_id');
            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('wx_member_order_id')->references('id')->on('wx_member_orders');
        });

        Schema::create('wx_member_bean_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('wx_member_id')->unsigned();
            $table->foreign('wx_member_id')->references('id')->on('wx_members');
            $table->string('action');
            $table->string('action_ch');
            $table->decimal('beans', 11, 4)->default(0.00);
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
        Schema::table('wx_member_bean_logs', function (Blueprint $table) {
            $table->dropForeign('wx_member_bean_logs_member_id_foreign');
        });

        Schema::table('wx_member_order_product', function (Blueprint $table) {
            $table->dropForeign('wx_member_order_product_order_id_foreign');
            $table->dropForeign('wx_order_product_product_id_foreign');
        });

        Schema::table('wx_member_orders', function (Blueprint $table) {
            $table->dropForeign('wx_member_orders_member_id_foreign');
        });

        Schema::table('wx_member_addresses', function (Blueprint $table) {
            $table->dropForeign('wx_member_addresses_member_id_foreign');
        });

        Schema::drop('wx_member_bean_logs');
        Schema::drop('wx_member_order_product');
        Schema::drop('wx_member_orders');
        Schema::drop('wx_member_addresses');
        Schema::drop('wx_members');
    }
}
