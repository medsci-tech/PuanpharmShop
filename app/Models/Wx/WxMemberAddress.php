<?php

namespace App\Models\Wx;

use Illuminate\Database\Eloquent\Model;

/**
 * Class MemberAddress
 * @package App\Models\Member
 * @mixin \Eloquent
 */
class WxMemberAddress extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'wx_member_addresses';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'wx_member_id',
        'phone',
        'name',
        'zipcode',
        'province',
        'city',
        'district',
        'address',
        'default'
    ];
}