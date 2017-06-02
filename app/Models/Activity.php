<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Activity
 *
 * @package App\Models
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Product[] $products
 * @property int $id
 * @property string $activity_name
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Activity whereActivityName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Activity whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Activity whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Activity whereUpdatedAt($value)
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