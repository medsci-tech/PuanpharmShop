<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class BeanLog
 *
 * @package App\Models
 * @mixin \Eloquent
 * @property int $id
 * @property int $customer_id
 * @property string $action
 * @property string $action_ch
 * @property float $beans
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BeanLog whereAction($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BeanLog whereActionCh($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BeanLog whereBeans($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BeanLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BeanLog whereCustomerId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BeanLog whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BeanLog whereUpdatedAt($value)
 */
class BeanLog extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'bean_log';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'customer_id',
        'action',
        'beans',
    ];
}