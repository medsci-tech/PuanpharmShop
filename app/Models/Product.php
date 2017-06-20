<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * Class Product
 *
 * @package App\Models
 * @mixin \Eloquent
 * @property-read \App\Models\Activity $activity
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ProductBanner[] $banners
 * @property-read \App\Models\Category $category
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Order[] $orders
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ProductSpecification[] $specifications
 * @property-read \App\Models\Supplier $supplier
 * @property-read \App\Models\ProductType $type
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Product search($seed)
 * @property int $id
 * @property int $category_id
 * @property int $puan_id
 * @property string $name
 * @property string $description
 * @property string $detail
 * @property float $price
 * @property string $default_spec
 * @property float $beans
 * @property string $tags
 * @property string $logo
 * @property int $sale_counts
 * @property int $view_counts
 * @property bool $is_on_sale
 * @property bool $is_show
 * @property int $weight
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @property int $type_id
 * @property int $supplier_id
 * @property int $activity_id
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Product whereActivityId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Product whereBeans($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Product whereCategoryId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Product whereDefaultSpec($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Product whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Product whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Product whereDetail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Product whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Product whereIsOnSale($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Product whereIsShow($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Product whereLogo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Product whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Product wherePrice($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Product wherePuanId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Product whereSaleCounts($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Product whereSupplierId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Product whereTags($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Product whereTypeId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Product whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Product whereViewCounts($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Product whereWeight($value)
 * @property int $is_abroad 是否海淘商品 是:1 0:否
 * @property float $price_tax 海淘税费
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Product whereIsAbroad($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Product wherePriceTax($value)
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
        'is_abroad',
        'price_tax',
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