<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Product
 * @package App\Models
 * @mixin \Eloquent
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