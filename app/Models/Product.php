<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * Class Product
 * @package App\Models
 * @mixin \Eloquent
 */
class Product extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'products';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'category_id',
        'supplier_id',
        'activity_id',
        'puan_id',
        'is_on_sale',
        'is_show',
        'name',
        'description',
        'price',
        'beans',
        'tags',
        'logo',
        'detail',
        'default_spec',
        'weight',
    ];

    public function category()
    {
        return $this->belongsTo('App\Models\Category', 'category_id');
    }

    public function supplier()
    {
        return $this->belongsTo('App\Models\Supplier', 'supplier_id');
    }

    public function activity()
    {
        return $this->belongsTo(Activity::class, 'activity_id');
    }

    public function type()
    {
        return $this->belongsTo('App\Models\ProductType', 'type_id');
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class)->withPivot(['quantity', 'specification_id']);
    }

    public function banners()
    {
        return $this->hasMany(ProductBanner::class);
    }

    public function specifications()
    {
        return $this->hasMany(ProductSpecification::class);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var $query
     */
    public function scopeSearch($query, $seed)
    {
        return $query->where('name', 'like', '%' . $seed . '%')
            ->orWhere('description', 'like', '%' . $seed . '%')
            ->orWhere('tags', 'like', '%' . $seed . '%');
    }

    public function addSpec($data)
    {
        $this->specifications()->save(ProductSpecification::create($data));
        return $this;
    }

    public function addSpecs($items)
    {
        foreach ($items as $item) {
            $this->addSpec($item);
        }
        return $this;
    }

    public function addBanner($data)
    {
        $this->banners()->save(ProductBanner::create($data));
        return $this;
    }

    /**
     * @param array $items
     * @return $this
     */
    public function addBanners($items)
    {
        foreach ($items as $item) {
            $this->addBanner($item);
        }
        return $this;
    }

    public static function create(array $options = [])
    {
        $product = parent::create($options);

        if (array_key_exists('specDetails', $options)) {
            $spec = $options['specDetails'];
            $product = $product->addSpecs($spec);
        }
        if (array_key_exists('banners', $options)) {
            $banners = $options['banners'];
            $product->addBanners($banners);
        }
        return $product;
    }
}