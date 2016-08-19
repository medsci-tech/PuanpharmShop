<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWxPaymentDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('wx_payment_details', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('customer_id')->unsigned();
            $table->foreign('customer_id')->references('id')->on('customers');

            $table->string('transaction_id')->comment('微信支付订单号');
            $table->string('out_trade_no')->comment('商户订单号');
            $table->string('appid')->comment('公众账号ID');
            $table->string('mch_id')->comment('商户号');
            $table->string('device_info')->comment('设备号');
            $table->string('nonce_str')->comment('随机字符串');
            $table->string('sign')->comment('签名');
            $table->string('result_code')->comment('业务结果');
            $table->string('err_code')->comment('错误代码');
            $table->string('err_code_des')->comment('错误代码描述');
            $table->string('openid')->comment('用户标识');
            $table->string('is_subscribe')->comment('是否关注公众账号');
            $table->string('trade_type')->comment('交易类型');
            $table->string('bank_type')->comment('付款银行');
            $table->integer('total_fee')->comment('订单金额');
            $table->integer('settlement_total_fee')->comment('应结订单金额');
            $table->string('fee_type')->comment('货币种类');
            $table->integer('cash_fee')->comment('现金支付金额');
            $table->string('cash_fee_type')->comment('现金支付货币类型');
            $table->integer('coupon_fee')->comment('代金券金额');
            $table->integer('coupon_count')->comment('代金券使用数量');
            $table->string('attach')->comment('商家数据包');
            $table->string('time_end')->comment('支付完成时间');
            $table->timestamps();
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->unsignedInteger('wx_payment_detail_id')->nullable();
            $table->foreign('wx_payment_detail_id')
                ->references('id')->on('wx_payment_details');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign('orders_wx_payment_detail_id_foreign');
            $table->dropColumn('wx_payment_detail_id');
        });
        Schema::drop('wx_payment_details');
    }
}
