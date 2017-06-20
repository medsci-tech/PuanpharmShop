<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Order
 *
 * @package App\Models
 * @mixin \Eloquent
 * @property-read \App\Models\Address $address
 * @property-read \App\Models\Customer $customer
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Product[] $products
 * @property-read \App\Models\Supplier $supplier
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order search($seed)
 * @property int $id
 * @property string $order_sn
 * @property string $out_trade_no
 * @property string $shipping_no
 * @property float $total_fee
 * @property float $shipping_fee
 * @property float $products_fee
 * @property float $beans_fee
 * @property float $pay_fee
 * @property bool $status
 * @property bool $payment_status
 * @property string $delivered_at
 * @property string $remark
 * @property string $address_phone
 * @property string $address_name
 * @property string $address_province
 * @property string $address_city
 * @property string $address_district
 * @property string $address_detail
 * @property int $customer_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * @property int $supplier_id
 * @property int $wx_payment_detail_id
 * @property string $ems_num
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order whereAddressCity($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order whereAddressDetail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order whereAddressDistrict($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order whereAddressName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order whereAddressPhone($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order whereAddressProvince($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order whereBeansFee($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order whereCustomerId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order whereDeliveredAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order whereEmsNum($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order whereOrderSn($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order whereOutTradeNo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order wherePayFee($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order wherePaymentStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order whereProductsFee($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order whereRemark($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order whereShippingFee($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order whereShippingNo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order whereSupplierId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order whereTotalFee($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order whereWxPaymentDetailId($value)
 * @property string $shipping_type
 * @property int $coupon_id
 * @property float $tax_fee
 * @property float $cut_fee
 * @property string $idCard 订单身份证号码(冗余字段)
 * @property-read \App\Models\Coupon $coupon
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order whereCouponId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order whereCutFee($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order whereIdCard($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order whereShippingType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order whereTaxFee($value)
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
        'pay_fee',
        'cut_fee',
        'tax_fee',
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
        'order_sn',
        'idCard',
        'ems_num',
        'coupon_id',
        'shipping_no',
        'shipping_type'
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

    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }
}