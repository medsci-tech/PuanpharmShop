<?php

namespace App\Models\Wx;

use Illuminate\Database\Eloquent\Model;

/**
 * Class WxMemberBeanLog
 * @package App\Models\Member
 * @mixin \Eloquent
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