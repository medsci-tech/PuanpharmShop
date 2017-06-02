<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


/**
 * App\Models\Customer
 *
 * @property int $id
 * @property string $phone
 * @property string $password
 * @property string $openid
 * @property string $unionid
 * @property string $nickname
 * @property string $head_image_url
 * @property float $total_beans
 * @property float $balance_beans
 * @property float $puan_beans
 * @property float $ohmate_beans
 * @property string $source
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property int $cooperator_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Address[] $addresses
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\BeanLog[] $beanLog
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Coupon[] $coupons
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Order[] $orders
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\WxPaymentDetail[] $wxPaymentDetails
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Customer whereBalanceBeans($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Customer whereCooperatorId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Customer whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Customer whereHeadImageUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Customer whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Customer whereNickname($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Customer whereOhmateBeans($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Customer whereOpenid($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Customer wherePassword($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Customer wherePhone($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Customer wherePuanBeans($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Customer whereSource($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Customer whereTotalBeans($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Customer whereUnionid($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Customer whereUpdatedAt($value)
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
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function coupons()
    {
        return $this->hasMany(Coupon::class);
    }

    /**
     * @return mixed
     */
    public function consumeBackBeans($beans)
    {
        $this->total_beans += $beans;
        $this->balance_beans += $beans;
        $this->puan_beans += $beans;
        $this->save();
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
        $this->balance_beans -= $beans;
        $this->save();

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
        return BeanLog::where('customer_id', $this->id)->where('created_at', '>', $month)->where('created_at', '<', $nextMonth)->orderBy('created_at', 'desc')->get();
    }
}