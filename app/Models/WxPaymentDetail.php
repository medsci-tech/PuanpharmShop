<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Product
 *
 * @package App\Models
 * @mixin \Eloquent
 * @property-read \App\Models\Customer $customer
 * @property int $id
 * @property int $customer_id
 * @property string $transaction_id 微信支付订单号
 * @property string $out_trade_no 商户订单号
 * @property string $appid 公众账号ID
 * @property string $mch_id 商户号
 * @property string $device_info 设备号
 * @property string $nonce_str 随机字符串
 * @property string $sign 签名
 * @property string $result_code 业务结果
 * @property string $err_code 错误代码
 * @property string $err_code_des 错误代码描述
 * @property string $openid 用户标识
 * @property string $is_subscribe 是否关注公众账号
 * @property string $trade_type 交易类型
 * @property string $bank_type 付款银行
 * @property int $total_fee 订单金额
 * @property int $settlement_total_fee 应结订单金额
 * @property string $fee_type 货币种类
 * @property int $cash_fee 现金支付金额
 * @property string $cash_fee_type 现金支付货币类型
 * @property int $coupon_fee 代金券金额
 * @property int $coupon_count 代金券使用数量
 * @property string $attach 商家数据包
 * @property string $time_end 支付完成时间
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\WxPaymentDetail whereAppid($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\WxPaymentDetail whereAttach($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\WxPaymentDetail whereBankType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\WxPaymentDetail whereCashFee($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\WxPaymentDetail whereCashFeeType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\WxPaymentDetail whereCouponCount($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\WxPaymentDetail whereCouponFee($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\WxPaymentDetail whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\WxPaymentDetail whereCustomerId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\WxPaymentDetail whereDeviceInfo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\WxPaymentDetail whereErrCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\WxPaymentDetail whereErrCodeDes($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\WxPaymentDetail whereFeeType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\WxPaymentDetail whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\WxPaymentDetail whereIsSubscribe($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\WxPaymentDetail whereMchId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\WxPaymentDetail whereNonceStr($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\WxPaymentDetail whereOpenid($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\WxPaymentDetail whereOutTradeNo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\WxPaymentDetail whereResultCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\WxPaymentDetail whereSettlementTotalFee($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\WxPaymentDetail whereSign($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\WxPaymentDetail whereTimeEnd($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\WxPaymentDetail whereTotalFee($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\WxPaymentDetail whereTradeType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\WxPaymentDetail whereTransactionId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\WxPaymentDetail whereUpdatedAt($value)
 */
class WxPaymentDetail extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'wx_payment_details';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'transaction_id',
        'out_trade_no',
        'appid',
        'mch_id',
        'device_info',
        'nonce_str',
        'sign',
        'result_code',
        'err_code',
        'openid',
        'is_subscribe',
        'trade_type',
        'bank_type',
        'total_fee',
        'settlement_total_fee',
        'fee_type',
        'cash_fee',
        'cash_fee_type',
        'coupon_fee',
        'coupon_count',
        'time_end'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}