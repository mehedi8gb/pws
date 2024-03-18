<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\Sluggable;

class File extends Model
{
use SoftDeletes, HasFactory;

    protected $fillable = [
        'files',
        'file_path',
        'file_type',
        'user_id',
        'order_id',
    ];

    protected array $dates = [
        'created_at',
        'updated_at',
    ];

    protected $casts = [
//        'file_path' => 'encrypted',
    ];
}
