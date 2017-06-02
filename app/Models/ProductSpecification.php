<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ProductSpecification
 *
 * @package App\Models
 * @mixin \Eloquent
 * @property-read \App\Models\Product $product
 * @property int $id
 * @property string $specification_name
 * @property float $specification_price
 * @property int $product_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ProductSpecification whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ProductSpecification whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ProductSpecification whereProductId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ProductSpecification whereSpecificationName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ProductSpecification whereSpecificationPrice($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ProductSpecification whereUpdatedAt($value)
 */
class ProductSpecification extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'product_specifications';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'specification_name',
        'specification_price'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

}