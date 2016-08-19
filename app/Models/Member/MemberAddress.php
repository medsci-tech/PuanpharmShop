<?php

namespace App\Models\Member;

use Illuminate\Database\Eloquent\Model;

/**
 * Class MemberAddress
 * @package App\Models\Member
 * @mixin \Eloquent
 */
class MemberAddress extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'member_addresses';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'member_id',
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