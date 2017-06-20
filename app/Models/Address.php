<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Address
 *
 * @mixin \Eloquent
 * @property int $id
 * @property int $customer_id
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
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Address whereAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Address whereCity($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Address whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Address whereCustomerId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Address whereDefault($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Address whereDistrict($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Address whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Address whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Address wherePhone($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Address whereProvince($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Address whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Address whereZipcode($value)
 * @property string $idCard 身份证号码
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Address whereIdCard($value)
 */
class Address extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'addresses';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'customer_id',
        'phone',
        'name',
        'idCard',
        'zipcode',
        'province',
        'city',
        'district',
        'address',
        'default'
    ];

}