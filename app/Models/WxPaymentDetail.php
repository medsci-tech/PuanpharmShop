<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Product
 * @package App\Models
 * @mixin \Eloquent
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