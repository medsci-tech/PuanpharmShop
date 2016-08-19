<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Activity
 * @package App\Models
 * @mixin \Eloquent
 */
class Activity extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'activities';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'activity_name'
    ];

    public function products()
    {
        return $this->hasMany(Product::class)->orderBy('weight', 'desc');
    }

}