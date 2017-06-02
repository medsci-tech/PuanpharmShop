<?php


namespace App\BasicShop\Cart;


use App\Models\Coupon;
use App\Models\Product;

class Cart
{
    protected $products;
    protected $coupon;

    public function __construct()
    {
        $this->products = [];
        $this->coupon = null;
    }

    public function addProduct($product_id, $quantity)
    {
        if (array_has($this->products, $this->products[$product_id])) {
            $this->products[$product_id]['quantity'] += $quantity;
        }

        /** @var Product $product */
        $product = Product::findOrFail($product_id);

        $product_snapshot = [
            'id' => $product->id,
            'single_price' => $product->price,
            'quantity' => $quantity,
            'total_price' => $product->price * $quantity
        ];

        $this->products[$product_id] = $product_snapshot;

        return $this;
    }

    public function addProducts($product_ids_with_quantities)
    {
        foreach ($product_ids_with_quantities as $product_id => $quantity) {
            $this->addProduct($product_id, $quantity);
        }

        return $this;
    }

    public function removeProduct($product_id, $quantity = 0)
    {
        if (!array_has($this->products, $product_id)) {
            return false;
        }

        $this->coupon = null;
        if ($quantity > 0 && $quantity < $this->products[$product_id]['quantity']) {
            $this->products[$product_id]['quantity'] -= $quantity;
            $this->products[$product_id]['total_price'] -= $quantity * $this->products[$product_id]['single_price'];
        } else {
            unset($this->products[$product_id]);
        }

        return $this;
    }

    public function addCoupon($coupon_id)
    {
        $coupon = Coupon::find($coupon_id);
        if (!$coupon || !$coupon->couponType) {
            return false;
        }

        if ($coupon->couponType->price_required > $this->totalPrice()) {
            return false;
        }

        if ($product_id_required = $coupon->couponType->product_id_required) {
            if (!array_has($this->products, $product_id_required)) {
                return false;
            }
        }

        $this->coupon = $coupon_id;
    }

    public function totalPrice()
    {
        $total = 0.00;
        foreach ($this->products as $product) {
            $total += $product['total_price'];
        }

        return $total;
    }

    public function adjustedPrice()
    {
        if ($this->coupon) {
            $coupon = Coupon::find($this->coupon);
            $coupon_type = $coupon->couponType;

            if ($coupon_type->cut_percentage) {
                return $this->totalPrice() * (1 - $coupon_type->cut_percentage);
            }

            if ($coupon_type->cut_price) {
                return $this->totalPrice() - $coupon_type->cut_price;
            }
        }

        return $this->totalPrice();
    }

    public function save() {
        \Session::put('cart', $this);
        return $this;
    }

    public function clear()
    {
        return \Session::remove('cart');
    }
}