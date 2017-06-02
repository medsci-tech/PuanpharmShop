<?php

namespace App\Models\Member;

use Illuminate\Database\Eloquent\Model;

/**
 * Class MemberAddress
 *
 * @package App\Models\Member
 * @mixin \Eloquent
 * @property int $id
 * @property int $member_id
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
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Member\MemberAddress whereAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Member\MemberAddress whereCity($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Member\MemberAddress whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Member\MemberAddress whereDefault($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Member\MemberAddress whereDistrict($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Member\MemberAddress whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Member\MemberAddress whereMemberId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Member\MemberAddress whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Member\MemberAddress wherePhone($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Member\MemberAddress whereProvince($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Member\MemberAddress whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Member\MemberAddress whereZipcode($value)
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