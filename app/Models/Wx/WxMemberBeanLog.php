<?php

namespace App\Models\Wx;

use Illuminate\Database\Eloquent\Model;

/**
 * Class WxMemberBeanLog
 *
 * @package App\Models\Member
 * @mixin \Eloquent
 * @property int $id
 * @property int $wx_member_id
 * @property string $action
 * @property string $action_ch
 * @property float $beans
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Wx\WxMemberBeanLog whereAction($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Wx\WxMemberBeanLog whereActionCh($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Wx\WxMemberBeanLog whereBeans($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Wx\WxMemberBeanLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Wx\WxMemberBeanLog whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Wx\WxMemberBeanLog whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Wx\WxMemberBeanLog whereWxMemberId($value)
 */
class WxMemberBeanLog extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'wx_member_bean_logs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'wx_member_id',
        'action',
        'beans',
    ];
}