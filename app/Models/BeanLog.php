<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class BeanLog
 * @package App\Models
 * @mixin \Eloquent
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