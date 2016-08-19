<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('order_sn');
            $table->string('out_trade_no');
            $table->string('shipping_no');
            $table->decimal('total_fee')->default(0.00);
            $table->decimal('shipping_fee')->default(0.00);
            $table->decimal('products_fee')->default(0.00);
            $table->decimal('beans_fee')->default(0.00);
            $table->decimal('pay_fee')->default(0.00);
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
            $table->integer('customer_id')->unsigned();
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign('orders_customer_id_foreign');
            $table->dropColumn('customer_id');
        });
        Schema::drop('orders');
    }
}
