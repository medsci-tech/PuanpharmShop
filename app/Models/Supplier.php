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
 * @property string $supplier_name 供应商名称
 * @property string $supplier_desc 供应商描述
 * @property string $logo_image_url Logo图片地址
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Supplier whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Supplier whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Supplier whereLogoImageUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Supplier whereSupplierDesc($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Supplier whereSupplierName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Supplier whereUpdatedAt($value)
 */
class Supplier extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'suppliers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'supplier_name',
        'supplier_desc'
    ];
    public function products()
    {
        return $this->hasMany('App\Models\Product');
    }

}