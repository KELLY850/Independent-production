<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Items extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = [
        'user_id',
        'name',
        'type',
        'price',
        'status',
        'image',
        'detail',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
    ];

    /**
     * カテゴリー名
     */
    public function getPrefNameAttribute()
    {
       return config('category.'.$this->type);
    }

}
