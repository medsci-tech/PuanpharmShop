<?php

namespace App\Models\Member;

use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MemberOrder
 * @package App\Models\Member
 * @mixin \Eloquent
 */
class MemberOrder extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'member_orders';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'total_fee',
        'beans_fee',
        'products_fee',
        'shipping_fee',
        'member_id',
        'supplier_id',
        'remark',
        'address_phone',
        'address_name',
        'address_province',
        'address_city',
        'address_district',
        'address_detail',
        'order_sn'
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot(['quantity', 'specification_id']);
    }

    public static function create(array $options = [])
    {
        //separate order products
        $products = $options['details'];
        unset($options['detail'], $options['details']);
        $order = parent::create($options);
        $order->addProducts($products);
        return $order;
    }

    /**
     * @param Product $product
     * @param $quantity
     * @return $this
     */
    public function addProduct(Product $product, $quantity, $specification = null)
    {
        if ($specification) {
            $this->products()->save($product, ['quantity' => $quantity, 'specification_id' => $specification->id]);
            $this->increasePrice(floatval($specification->specification_price * $quantity));
        } else {
            $this->products()->save($product, ['quantity' => $quantity]);
            $this->increasePrice(floatval($product->price * $quantity));
        }
        return $this;
    }

    /**
     * @param array $items
     * @return $this
     */
    public function addProducts(array $items)
    {
        foreach ($items as $item) {
            if (isset($item['specification'])) {

                $this->addProduct($item['product'], $item['quantity'], $item['specification']);
            } else {
                $this->addProduct($item['product'], $item['quantity']);
            }
        }
        return $this;
    }

    /**
     * @param $price
     * @return $this
     */
    public function increasePrice($price)
    {
        $this->products_fee = $this->products_fee + $price;
        return $this->save();
    }

    /**
     * @param string $outTradeNo
     * @return bool
     */
    public function paid($outTradeNo)
    {

    }

    /**
     * @return bool
     */
    public function isPaid()
    {

    }

    /**
     * The attributes that are mass assignable.
     *
     * @var $query
     */
    public function scopeSearch($query, $seed)
    {
        return $query->where('order_sn', 'like', '%' . $seed . '%')
            ->orWhere('total_fee', 'like', '%' . $seed . '%')
            ->orWhere('out_trade_no', 'like', '%' . $seed . '%')
            ->orWhere('address_phone', 'like', '%' . $seed . '%')
            ->orWhere('address_name', 'like', '%' . $seed . '%')
            ->orWhere('address_province', 'like', '%' . $seed . '%')
            ->orWhere('address_city', 'like', '%' . $seed . '%')
            ->orWhere('address_district', 'like', '%' . $seed . '%')
            ->orWhere('address_detail', 'like', '%' . $seed . '%')
            ->orWhere('id', 'like', '%' . $seed . '%')
            ->orWhere('customer_id', 'like', '%' . $seed . '%');
    }
}