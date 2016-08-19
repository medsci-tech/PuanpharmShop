<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Customer
 *
 * @package App\Models
 * @mixin \Eloquent
 */
class Customer extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'customers';

    protected $hidden = ['password'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function addresses()
    {
        return $this->hasMany('App\Models\Address');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function beanLog()
    {
        return $this->hasMany(BeanLog::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders()
    {
        return $this->hasMany(Order::class)->where('payment_status', 1);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function wxPaymentDetails()
    {
        return $this->hasMany(WxPaymentDetail::class);
    }

    /**
     * @return mixed
     */
    public function ordersWithProducts()
    {
        return $this->orders()->with(['products' => function ($query) {
            $query->get();
        }]);
    }

    /**
     * @return mixed
     */
    public function consumeBackBeans($beans)
    {
        // 更新beans
        $this->total_beans += $beans;
        $this->balance_beans += $beans;
        $this->puan_beans += $beans;
        $this->save();
        // 日志
        $array = [
            'action' => 'consume_back',
            'beans' => $beans
        ];
        return $this->beanLog()->create($array);
    }

    /**
     * @return mixed
     */
    public function consumeBeans($beans)
    {
        // 更新beans
        $this->balance_beans -= $beans;
        $this->save();
        // 日志
        $array = [
            'action' => 'consume',
            'beans' => $beans
        ];
        return $this->beanLog()->create($array);
    }

    /**
     * @param $month
     * @return mixed
     */
    public function monthBeans($month)
    {
        $date = explode('-', $month);
        $nextMonth = $date[0] . '-0' . ++$date[1];
        return $this->hasMany(BeanLog::class, 'customer_id')->where('created_at', '>', $month)->where('created_at', '<', $nextMonth)->orderBy('created_at', 'desc')->get();
    }
}