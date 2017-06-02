<?php

namespace App\Models\Wx;

use Illuminate\Database\Eloquent\Model;

/**
 * Class WxMember
 *
 * @package App\Models\Member
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Wx\WxMemberAddress[] $addresses
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Wx\WxMemberBeanLog[] $beanLogs
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Wx\WxMemberOrder[] $orders
 * @property int $id
 * @property string $phone
 * @property string $openid
 * @property string $source
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Wx\WxMember whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Wx\WxMember whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Wx\WxMember whereOpenid($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Wx\WxMember wherePhone($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Wx\WxMember whereSource($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Wx\WxMember whereUpdatedAt($value)
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