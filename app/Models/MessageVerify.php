<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class MessageVerify
 *
 * @package App
 * @mixin \Eloquent
 * @property integer $id 主键.
 * @property string $phone 手机号码.
 * @property string $code 验证码.
 * @property boolean $status 验证码状态，1表示已经被使用过.
 * @property boolean $expired 验证码过期时间.
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MessageVerify whereCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MessageVerify whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MessageVerify whereExpired($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MessageVerify whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MessageVerify wherePhone($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MessageVerify whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MessageVerify whereUpdatedAt($value)
 */
class MessageVerify extends Model
{
    protected $table = 'message_verifies';
}
