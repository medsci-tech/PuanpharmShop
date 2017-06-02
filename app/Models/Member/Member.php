<?php

namespace App\Models\Member;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Member
 *
 * @package App\Models\Member
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Member\MemberAddress[] $addresses
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Member\MemberBeanLog[] $beanLogs
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Member\MemberOrder[] $orders
 * @property int $id
 * @property string $phone
 * @property string $openid
 * @property string $source
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Member\Member whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Member\Member whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Member\Member whereOpenid($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Member\Member wherePhone($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Member\Member whereSource($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Member\Member whereUpdatedAt($value)
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