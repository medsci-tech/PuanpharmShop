<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\CouponType
 *
 * @mixin \Eloquent
 * @property int $id
 * @property string $type
 * @property float $price_required
 * @property int $product_id_required
 * @property float $cut_price
 * @property float $cut_percentage
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CouponType whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CouponType whereCutPercentage($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CouponType whereCutPrice($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CouponType whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CouponType wherePriceRequired($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CouponType whereProductIdRequired($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CouponType whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\CouponType whereUpdatedAt($value)
 */
class CouponType extends Model
{
    //
}
