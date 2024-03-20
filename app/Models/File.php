<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cviebrock\EloquentSluggable\Sluggable;

/**
 * @method static where(string $string, mixed $order_id)
 */
class File extends Model
{
use SoftDeletes, HasFactory;

    protected $fillable = [
        'file_name',
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
        'file_name' => 'encrypted',
        'file_path' => 'encrypted',
    ];
}
