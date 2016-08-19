<?php

namespace App\Models\Member;

use Illuminate\Database\Eloquent\Model;

/**
 * Class MemberBeanLog
 * @package App\Models\Member
 * @mixin \Eloquent
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