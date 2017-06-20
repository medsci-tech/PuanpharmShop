<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\StashedCoupon
 *
 * @mixin \Eloquent
 * @property int $id
 * @property int $coupon_type_id
 * @property bool $delivered
 * @property string $unionid
 * @property string $source
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $delivered_at
 * @property \Carbon\Carbon $expire_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\StashedCoupon whereCouponTypeId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\StashedCoupon whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\StashedCoupon whereDelivered($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\StashedCoupon whereDeliveredAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\StashedCoupon whereExpireAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\StashedCoupon whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\StashedCoupon whereSource($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\StashedCoupon whereUnionid($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\StashedCoupon whereUpdatedAt($value)
 */
class StashedCoupon extends Model
{
    protected $dates = [
        'created_at',
        'updated_at',
        'expire_at',
        'delivered_at'
    ];
}
