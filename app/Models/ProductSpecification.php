<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ProductSpecification
 * @package App\Models
 * @mixin \Eloquent
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