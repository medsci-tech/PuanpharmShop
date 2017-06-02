<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Banner
 *
 * @package App\Models
 * @mixin \Eloquent
 * @property int $id
 * @property string $image_url
 * @property string $href_url
 * @property int $weight
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Banner whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Banner whereHrefUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Banner whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Banner whereImageUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Banner whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Banner whereWeight($value)
 */
class Banner extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'banners';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'image_url',
        'weight',
        'href_url',
    ];
}