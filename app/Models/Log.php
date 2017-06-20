<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Banner
 *
 * @package App\Models
 * @mixin \Eloquent
 * @property int $id
 * @property int $customer_id 用户id
 * @property string $action 规则类型
 * @property int $beans2 请求接口之后的积分值
 * @property int $beans 请求接口之前的积分值
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $order_id 订单id
 * @property string $phone 电话冗余
 * @property float $cash_paid_by_beans 迈豆抵扣的人民币数额
 * @property float $cash_paid 实际支付的人民币数额
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Log whereAction($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Log whereBeans($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Log whereBeans2($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Log whereCashPaid($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Log whereCashPaidByBeans($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Log whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Log whereCustomerId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Log whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Log whereOrderId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Log wherePhone($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Log whereUpdatedAt($value)
 */
class Log extends Model
{

}