<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Product
 *
 * @package App\Models
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Product[] $products
 * @property int $id
 * @property string $type_en 用户类型-英
 * @property string $type_ch 用户类型-中
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ProductType whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ProductType whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ProductType whereTypeCh($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ProductType whereTypeEn($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ProductType whereUpdatedAt($value)
 */
class ProductType extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'product_types';

    public function products()
    {
        return $this->hasMany('App\Models\Product');
    }

}