<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ProductBanner
 *
 * @package App\Models
 * @mixin \Eloquent
 * @property-read \App\Models\Product $product
 * @property int $id
 * @property string $image_url
 * @property int $weight
 * @property int $product_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ProductBanner whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ProductBanner whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ProductBanner whereImageUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ProductBanner whereProductId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ProductBanner whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ProductBanner whereWeight($value)
 */
class ProductBanner extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'product_banners';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'image_url',
        'weight'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

}