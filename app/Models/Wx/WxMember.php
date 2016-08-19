<?php

namespace App\Models\Wx;

use Illuminate\Database\Eloquent\Model;

/**
 * Class WxMember
 *
 * @package App\Models\Member
 * @mixin \Eloquent
 */
class WxMember extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'wx_members';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function addresses()
    {
        return $this->hasMany(WxMemberAddress::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function beanLogs()
    {
        return $this->hasMany(WxMemberBeanLog::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders()
    {
        return $this->hasMany(WxMemberOrder::class)->where('payment_status', 1);
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
}