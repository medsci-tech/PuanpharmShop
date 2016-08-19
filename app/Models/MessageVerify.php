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
 */
class MessageVerify extends Model
{
    protected $table = 'message_verifies';
}
