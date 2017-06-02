<?php

namespace App\Models\Member;

use Illuminate\Database\Eloquent\Model;

/**
 * Class MemberBeanLog
 *
 * @package App\Models\Member
 * @mixin \Eloquent
 * @property int $id
 * @property int $member_id
 * @property string $action
 * @property string $action_ch
 * @property float $beans
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Member\MemberBeanLog whereAction($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Member\MemberBeanLog whereActionCh($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Member\MemberBeanLog whereBeans($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Member\MemberBeanLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Member\MemberBeanLog whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Member\MemberBeanLog whereMemberId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Member\MemberBeanLog whereUpdatedAt($value)
 */
class MemberBeanLog extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'member_bean_logs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'member_id',
        'action',
        'beans',
    ];
}