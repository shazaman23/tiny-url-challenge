<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TinyUrl extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'string';
    protected $casts = [
        'id' => 'string'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'full_url', 'hits', 'nsfw'
    ];

    /**
     * The attributes that are not needed when model is fetched.
     */
    protected $hidden = [
        'created_at', 'updated_at', 'seed'
    ];
}
