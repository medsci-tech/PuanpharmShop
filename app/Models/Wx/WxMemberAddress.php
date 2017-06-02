<?php

namespace App\Models\Wx;

use Illuminate\Database\Eloquent\Model;

/**
 * Class MemberAddress
 *
 * @package App\Models\Member
 * @mixin \Eloquent
 * @property int $id
 * @property int $wx_member_id
 * @property bool $default
 * @property string $phone
 * @property string $name
 * @property int $zipcode
 * @property string $province
 * @property string $city
 * @property string $district
 * @property string $address
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Wx\WxMemberAddress whereAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Wx\WxMemberAddress whereCity($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Wx\WxMemberAddress whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Wx\WxMemberAddress whereDefault($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Wx\WxMemberAddress whereDistrict($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Wx\WxMemberAddress whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Wx\WxMemberAddress whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Wx\WxMemberAddress wherePhone($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Wx\WxMemberAddress whereProvince($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Wx\WxMemberAddress whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Wx\WxMemberAddress whereWxMemberId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Wx\WxMemberAddress whereZipcode($value)
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