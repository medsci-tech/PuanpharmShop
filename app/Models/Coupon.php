<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use function PHPSTORM_META\elementType;

/**
 * Class Coupon
 *
 * @package App\Models
 * @mixin \Eloquent
 * @property-read \App\Models\CouponType $couponType
 * @property int $id
 * @property int $coupon_type_id
 * @property int $customer_id
 * @property bool $used
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Coupon whereCouponTypeId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Coupon whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Coupon whereCustomerId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Coupon whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Coupon whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Coupon whereUsed($value)
 */
class Coupon extends Model
{
    protected $dates = [
        'created_at',
        'updated_at',
        'expire_at'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo | \App\Models\CouponType
     */
    public function couponType()
    {
        return $this->belongsTo(CouponType::class);
    }

    /**
     * @return $this|bool
     */
    public function markUsed()
    {
        if ($this->used) {
            return false;
        }

        $this->used = true;
        $this->save();

        return $this;
    }

    /**
     * @param float $total_money
     * @return bool
     */
    public function validateForTotalMoney(float $total_money)
    {
        if ($this->couponType->price_required > $total_money) {
            return false;
        }

        return true;
    }
}
