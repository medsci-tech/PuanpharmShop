<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Banner
 * @package App\Models
 * @mixin \Eloquent
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