<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Order
 * @package App\Models
 * @mixin \Eloquent
 */
class Order extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'orders';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'total_fee',
        'products_fee',
        'shipping_fee',
        'beans_fee',
        'customer_id',
        'supplier_id',
        'address_id',
        'remark',
        'address_phone',
        'address_name',
        'address_province',
        'address_city',
        'address_district',
        'address_detail',
        'order_sn'
    ];

    public function customer()
    {
        return $this->belongsTo('App\Models\Customer');
    }

    public function address()
    {
        return $this->belongsTo('App\Models\Address');
    }

    public function supplier()
    {
        return $this->belongsTo('App\Models\Supplier');
    }

    public function products()
    {
        return $this->belongsToMany('App\Models\Product')->withPivot(['quantity', 'specification_id']);
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
        $array = explode(" ", $outTradeNo);
        $idArray = array_shift($array);
        return Order::find($idArray)->update(['payment_status' => 1]);
    }

    /**
     * @return bool
     */
    public function isPaid()
    {

    }

    /**
     * @param string $outTradeNo
     */
    public function getOrdersByOutTradeNo($outTradeNo)
    {
        $array = explode(" ", $outTradeNo);
        $idArray = array_shift($array);
        return Order::find($idArray);
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