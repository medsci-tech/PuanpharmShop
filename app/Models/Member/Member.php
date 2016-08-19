<?php

namespace App\Models\Member;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Member
 *
 * @package App\Models\Member
 * @mixin \Eloquent
 */
class Member extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'members';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function addresses()
    {
        return $this->hasMany(MemberAddress::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function beanLogs()
    {
        return $this->hasMany(MemberBeanLog::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders()
    {
        return $this->hasMany(MemberOrder::class)->where('payment_status', 1);
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